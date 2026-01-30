<?php

namespace App\Http\Controllers;

use App\Models\SaleInvoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SaleInvoice::where('company_id', auth()->id())->with('customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('business_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $paidCount = SaleInvoice::where('company_id', auth()->id())->where('status', 'paid')->count();
        $pendingCount = SaleInvoice::where('company_id', auth()->id())->whereIn('status', ['pending', 'draft'])->count();
        $overdueCount = SaleInvoice::where('company_id', auth()->id())
                                    ->where('status', '!=', 'paid')
                                    ->where('due_date', '<', now())
                                    ->count();

        $invoices = $query->latest()->paginate(15);

        return view('invoices.index', compact('invoices', 'paidCount', 'pendingCount', 'overdueCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = \App\Models\Customer::where('company_id', auth()->id())->where('type', 'customer')->get();
        $products = \App\Models\Product::where('company_id', auth()->id())->get();
        $nextInvoiceNumber = SaleInvoice::generateInvoiceNumber(auth()->id());
        
        return view('invoices.create', compact('customers', 'products', 'nextInvoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers_vendors,id',
            'invoice_number' => [
                'required',
                'string',
                'max:50',
                new \App\Rules\UniqueInvoiceNumberInFinancialYear(
                    auth()->id(),
                    $request->invoice_date ?? date('Y-m-d')
                )
            ],
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'reference_number' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_rate' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'shipping_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'round_off' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        \DB::beginTransaction();
        try {
            $invoice = new SaleInvoice();
            $invoice->company_id = auth()->id();
            $invoice->customer_id = $validated['customer_id'];
            $invoice->invoice_number = $validated['invoice_number'];
            $invoice->invoice_date = $validated['invoice_date'];
            $invoice->due_date = $validated['due_date'] ?? $validated['invoice_date'];
            $invoice->reference_number = $validated['reference_number'];
            $invoice->discount_type = $validated['discount_type'] ?? 'fixed';
            $invoice->discount_value = $validated['discount_value'] ?? 0;
            $invoice->shipping_charges = $validated['shipping_charges'] ?? 0;
            $invoice->other_charges = $validated['other_charges'] ?? 0;
            $invoice->round_off = $validated['round_off'] ?? 0;
            $invoice->notes = $validated['notes'];
            $invoice->terms_conditions = $validated['terms_conditions'];
            $invoice->created_by = auth()->id();
            
            // Temporary values, will be recalculated
            $invoice->subtotal = 0;
            $invoice->total_amount = 0;
            $invoice->balance_amount = 0;
            $invoice->save();

            foreach ($validated['items'] as $itemData) {
                $product = \App\Models\Product::find($itemData['product_id']);
                
                $item = new \App\Models\SaleInvoiceItem();
                $item->sale_invoice_id = $invoice->id;
                $item->product_id = $itemData['product_id'];
                $item->quantity = $itemData['quantity'];
                $item->unit = $product->unit;
                $item->rate = $itemData['rate'];
                $item->discount_percentage = $itemData['discount_percentage'] ?? 0;
                $item->tax_rate = $itemData['tax_rate'] ?? 0;
                
                // Calculate item amounts
                $baseAmount = $item->quantity * $item->rate;
                $item->discount_amount = ($baseAmount * $item->discount_percentage) / 100;
                $item->taxable_amount = $baseAmount - $item->discount_amount;
                $item->tax_amount = ($item->taxable_amount * $item->tax_rate) / 100;
                $item->total_amount = $item->taxable_amount + $item->tax_amount;
                $item->save();

                // Update Stock
                $stockBefore = $product->current_stock;
                $product->current_stock -= $item->quantity;
                $product->available_stock = $product->current_stock - $product->committed_stock;
                $product->save();

                // Record Stock Movement
                \App\Models\StockMovement::create([
                    'company_id' => auth()->id(),
                    'product_id' => $product->id,
                    'movement_type' => 'out',
                    'transaction_type' => 'sale',
                    'reference_id' => $invoice->id,
                    'reference_number' => $invoice->invoice_number,
                    'movement_date' => $invoice->invoice_date,
                    'quantity' => $item->quantity,
                    'unit' => $product->unit,
                    'rate' => $item->rate,
                    'total_value' => $item->total_amount,
                    'stock_before' => $stockBefore,
                    'stock_after' => $product->current_stock,
                    'notes' => 'Sale Invoice #' . $invoice->invoice_number,
                    'created_by' => auth()->id(),
                ]);
            }

            $invoice->calculateTotals();
            
            \DB::commit();
            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }
        $invoice->load(['customer', 'items.product', 'company']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }
        $customers = \App\Models\Customer::where('company_id', auth()->id())->where('type', 'customer')->get();
        $products = \App\Models\Product::where('company_id', auth()->id())->get();
        $invoice->load('items');
        
        return view('invoices.edit', compact('invoice', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }

        // update is complex because of stock reversal, for simplicity often we just recreat or carefully adjust.
        // I will implement a simpler update that refreshes items but handles stock correctly.
        
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers_vendors,id',
            'invoice_number' => [
                'required',
                'string',
                'max:50',
                new \App\Rules\UniqueInvoiceNumberInFinancialYear(
                    auth()->id(),
                    $request->invoice_date ?? $invoice->invoice_date->format('Y-m-d'),
                    $invoice->id  // Exclude current invoice
                )
            ],
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'reference_number' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_rate' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'shipping_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'round_off' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        \DB::beginTransaction();
        try {
            // Reverse Stock for old items
            foreach ($invoice->items as $oldItem) {
                $product = $oldItem->product;
                $stockBefore = $product->current_stock;
                $product->current_stock += $oldItem->quantity;
                $product->available_stock = $product->current_stock - $product->committed_stock;
                $product->save();

                // Delete old movement
                \App\Models\StockMovement::where('reference_id', $invoice->id)
                    ->where('product_id', $product->id)
                    ->where('transaction_type', 'sale')
                    ->delete();
            }

            // Delete old items
            $invoice->items()->delete();

            // Update Invoice Header
            $invoice->customer_id = $validated['customer_id'];
            $invoice->invoice_number = $validated['invoice_number'];
            $invoice->invoice_date = $validated['invoice_date'];
            $invoice->due_date = $validated['due_date'] ?? $validated['invoice_date'];
            $invoice->reference_number = $validated['reference_number'];
            $invoice->discount_type = $validated['discount_type'] ?? 'fixed';
            $invoice->discount_value = $validated['discount_value'] ?? 0;
            $invoice->shipping_charges = $validated['shipping_charges'] ?? 0;
            $invoice->other_charges = $validated['other_charges'] ?? 0;
            $invoice->round_off = $validated['round_off'] ?? 0;
            $invoice->notes = $validated['notes'];
            $invoice->terms_conditions = $validated['terms_conditions'];
            $invoice->updated_by = auth()->id();
            $invoice->save();

            // Create new items and update stock
            foreach ($validated['items'] as $itemData) {
                $product = \App\Models\Product::find($itemData['product_id']);
                
                $item = new \App\Models\SaleInvoiceItem();
                $item->sale_invoice_id = $invoice->id;
                $item->product_id = $itemData['product_id'];
                $item->quantity = $itemData['quantity'];
                $item->unit = $product->unit;
                $item->rate = $itemData['rate'];
                $item->discount_percentage = $itemData['discount_percentage'] ?? 0;
                $item->tax_rate = $itemData['tax_rate'] ?? 0;
                
                // Calculate item amounts
                $baseAmount = $item->quantity * $item->rate;
                $item->discount_amount = ($baseAmount * $item->discount_percentage) / 100;
                $item->taxable_amount = $baseAmount - $item->discount_amount;
                $item->tax_amount = ($item->taxable_amount * $item->tax_rate) / 100;
                $item->total_amount = $item->taxable_amount + $item->tax_amount;
                $item->save();

                // Update Stock
                $stockBefore = $product->current_stock;
                $product->current_stock -= $item->quantity;
                $product->available_stock = $product->current_stock - $product->committed_stock;
                $product->save();

                // Record Stock Movement
                \App\Models\StockMovement::create([
                    'company_id' => auth()->id(),
                    'product_id' => $product->id,
                    'movement_type' => 'out',
                    'transaction_type' => 'sale',
                    'reference_id' => $invoice->id,
                    'reference_number' => $invoice->invoice_number,
                    'movement_date' => $invoice->invoice_date,
                    'quantity' => $item->quantity,
                    'unit' => $product->unit,
                    'rate' => $item->rate,
                    'total_value' => $item->total_amount,
                    'stock_before' => $stockBefore,
                    'stock_after' => $product->current_stock,
                    'notes' => 'Bulk update of Invoice #' . $invoice->invoice_number,
                    'created_by' => auth()->id(),
                ]);
            }

            $invoice->calculateTotals();
            
            \DB::commit();
            return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }

        \DB::beginTransaction();
        try {
            // Reverse Stock
            foreach ($invoice->items as $item) {
                $product = $item->product;
                $product->current_stock += $item->quantity;
                $product->available_stock = $product->current_stock - $product->committed_stock;
                $product->save();

                // Delete associated movements
                \App\Models\StockMovement::where('reference_id', $invoice->id)
                    ->where('product_id', $product->id)
                    ->where('transaction_type', 'sale')
                    ->delete();
            }

            $invoice->delete();
            \DB::commit();
            
            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    public function print(SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }
        $invoice->load(['customer', 'items.product', 'company']);
        return view('invoices.show', compact('invoice'));
    }

    public function download(SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }
        $invoice->load(['customer', 'items.product', 'company']);
        
        $pdf = Pdf::loadView('invoices.template', compact('invoice'))
                  ->setPaper('a4', 'portrait')
                  ->setWarnings(false);
        
        // Format filename as: invoice_no customer_name.pdf
        $customerName = $invoice->customer->business_name ?? 'Customer';
        // Sanitize customer name - remove special characters and replace spaces with underscores
        $customerName = preg_replace('/[^A-Za-z0-9\s]/', '', $customerName);
        $customerName = str_replace(' ', '_', $customerName);
        
        $filename = $invoice->invoice_number . ' ' . $customerName . '.pdf';
        
        return $pdf->download($filename);
    }

    public function markAsPaid(Request $request, SaleInvoice $invoice)
    {
        if ($invoice->company_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_date' => 'required|date',
        ]);

        // Mark invoice as paid
        $invoice->status = 'paid';
        $invoice->paid_amount = $invoice->total_amount;
        $invoice->balance_amount = 0;
        $invoice->paid_date = $validated['payment_date'];
        $invoice->save();

        // Generate payment number
        $lastPayment = \App\Models\Payment::where('company_id', auth()->id())
                                          ->orderBy('id', 'desc')
                                          ->first();
        $paymentNumber = 'PAY-' . date('Y') . '-' . str_pad(($lastPayment ? $lastPayment->id + 1 : 1), 4, '0', STR_PAD_LEFT);

        // Create payment record
        \App\Models\Payment::create([
            'company_id' => auth()->id(),
            'customer_id' => $invoice->customer_id,
            'payment_type' => 'received',
            'payment_number' => $paymentNumber,
            'sale_invoice_id' => $invoice->id,
            'payment_date' => $validated['payment_date'],
            'amount' => $invoice->total_amount,
            'payment_mode' => 'cash', // Default mode
            'notes' => 'Marked as paid from invoice list',
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Invoice marked as paid successfully.');
    }
}


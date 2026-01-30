<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('company_id', auth()->id());
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        
        // Filter by Stock Status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low_stock') {
                $query->whereRaw('current_stock <= min_stock_level');
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('current_stock', '<=', 0);
            } elseif ($request->stock_status === 'in_stock') {
                $query->where('current_stock', '>', 0);
            }
        }
        
        // Filter by Status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $totalCount = Product::where('company_id', auth()->id())->count();
        $inStockCount = Product::where('company_id', auth()->id())->where('current_stock', '>', 0)->count();
        $lowStockCount = Product::where('company_id', auth()->id())->whereRaw('current_stock <= min_stock_level')->count();

        $products = $query->latest()->paginate(15);
        
        return view('products.index', compact('products', 'totalCount', 'inStockCount', 'lowStockCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'product_code' => [
                    'nullable', 
                    'string', 
                    'max:50', 
                    Rule::unique('products')->where(function ($query) {
                        return $query->where('company_id', auth()->id());
                    })
                ],
                'sku' => [
                    'nullable', 
                    'string', 
                    'max:100', 
                    Rule::unique('products')->where(function ($query) {
                        return $query->where('company_id', auth()->id());
                    })
                ],
                'category' => 'nullable|string|max:100',
                'brand' => 'nullable|string|max:100',
                'unit' => 'required|string|max:50',
                'hsn_code' => 'nullable|string|max:20',
                'tax_rate' => 'required|numeric|min:0',
                'tax_type' => 'required|in:inclusive,exclusive',
                'purchase_price' => 'nullable|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'mrp' => 'nullable|numeric|min:0',
                'opening_stock' => 'nullable|numeric|min:0',
                'min_stock_level' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            $validated['company_id'] = auth()->id();
            $validated['current_stock'] = $validated['opening_stock'] ?? 0;
            $validated['available_stock'] = $validated['current_stock'];
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['allow_backorder'] = $request->boolean('allow_backorder', false);
            $validated['purchase_price'] = $validated['purchase_price'] ?? 0;

            $product = Product::create($validated);

            // Record opening stock movement if exists
            if ($product->opening_stock > 0) {
                \App\Models\StockMovement::create([
                    'company_id' => auth()->id(),
                    'product_id' => $product->id,
                    'movement_type' => 'in',
                    'transaction_type' => 'opening_stock',
                    'movement_date' => now(),
                    'quantity' => $product->opening_stock,
                    'unit' => $product->unit,
                    'rate' => $product->purchase_price,
                    'total_value' => $product->opening_stock * $product->purchase_price,
                    'stock_before' => 0,
                    'stock_after' => $product->opening_stock,
                    'notes' => 'Opening balance',
                    'created_by' => auth()->id(),
                ]);
            }

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    /**
     * Update the specifies resource.
     */
    public function addStock(Request $request, Product $product)
    {
        if ($product->company_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.001',
            'type' => 'required|in:in,out',
            'notes' => 'nullable|string|max:255',
        ]);

        $stockBefore = $product->current_stock;
        $qty = $validated['quantity'];
        
        if ($validated['type'] === 'in') {
            $product->current_stock += $qty;
            $type = 'in';
            $transType = 'adjustment_in';
        } else {
            $product->current_stock -= $qty;
            $type = 'out';
            $transType = 'adjustment_out';
        }

        $product->available_stock = $product->current_stock - $product->committed_stock;
        $product->save();

        \App\Models\StockMovement::create([
            'company_id' => auth()->id(),
            'product_id' => $product->id,
            'movement_type' => $type,
            'transaction_type' => $transType,
            'movement_date' => now(),
            'quantity' => $qty,
            'unit' => $product->unit,
            'rate' => $product->purchase_price,
            'total_value' => $qty * $product->purchase_price,
            'stock_before' => $stockBefore,
            'stock_after' => $product->current_stock,
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Stock updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if ($product->company_id !== auth()->id()) {
            abort(403);
        }
        
        $movements = $product->stockMovements()->latest()->take(10)->get();
        return view('products.show', compact('product', 'movements'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if ($product->company_id !== auth()->id()) {
            abort(403);
        }
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($product->company_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_code' => [
                'nullable', 
                'string', 
                'max:50', 
                Rule::unique('products')->where(function ($query) {
                    return $query->where('company_id', auth()->id());
                })->ignore($product->id)
            ],
            'sku' => [
                'nullable', 
                'string', 
                'max:100', 
                Rule::unique('products')->where(function ($query) {
                    return $query->where('company_id', auth()->id());
                })->ignore($product->id)
            ],
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'unit' => 'required|string|max:50',
            'hsn_code' => 'nullable|string|max:20',
            'tax_rate' => 'required|numeric|min:0',
            'tax_type' => 'required|in:inclusive,exclusive',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'min_stock_level' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'allow_backorder' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['allow_backorder'] = $request->has('allow_backorder');
        $validated['purchase_price'] = $validated['purchase_price'] ?? 0;
        
        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->company_id !== auth()->id()) {
            abort(403);
        }

        // Check if product is used in invoices
        if ($product->saleInvoiceItems()->exists()) {
            return back()->with('error', 'Cannot delete product because it has associated invoice records.');
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}

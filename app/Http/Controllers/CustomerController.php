<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::where('company_id', auth()->id());
        
        // Filter by type (customer or vendor)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Active/Inactive filter
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $totalCount = Customer::where('company_id', auth()->id())->count();
        $customerCount = Customer::where('company_id', auth()->id())->where('type', 'customer')->count();
        $vendorCount = Customer::where('company_id', auth()->id())->where('type', 'vendor')->count();

        $customers = $query->latest()->paginate(15);
        
        return view('customers', compact('customers', 'totalCount', 'customerCount', 'vendorCount'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:customer,vendor',
            'business_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'alternate_phone' => 'nullable|string|max:15',
            'gst_no' => 'nullable|string|size:15',
            'pan_no' => 'nullable|string|max:20',
            'billing_address' => 'required|string',
            'address_2' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|regex:/^[0-9]+$/|max:10',
            'country' => 'nullable|string|max:100',
            'opening_balance' => 'nullable|numeric|min:0',
            'balance_type' => 'nullable|in:debit,credit',
            'credit_limit' => 'nullable|numeric|min:0',
            'credit_days' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);
        
        $validated['company_id'] = auth()->id();
        $validated['country'] = $validated['country'] ?? 'India';
        $validated['is_active'] = $request->has('is_active');
        
        Customer::create($validated);
        
        return redirect()->route('customers.index')
                        ->with('success', ucfirst($validated['type']) . ' created successfully!');
    }

    public function show(Customer $customer)
    {
        // Ensure the customer belongs to the authenticated company
        if ($customer->company_id !== auth()->id()) {
            abort(403);
        }
        
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        // Ensure the customer belongs to the authenticated company
        if ($customer->company_id !== auth()->id()) {
            abort(403);
        }
        
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // Ensure the customer belongs to the authenticated company
        if ($customer->company_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'type' => 'required|in:customer,vendor',
            'business_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'alternate_phone' => 'nullable|string|max:15',
            'gst_no' => 'nullable|string|size:15',
            'pan_no' => 'nullable|string|max:20',
            'billing_address' => 'required|string',
            'address_2' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|regex:/^[0-9]+$/|max:10',
            'country' => 'nullable|string|max:100',
            'opening_balance' => 'nullable|numeric|min:0',
            'balance_type' => 'nullable|in:debit,credit',
            'credit_limit' => 'nullable|numeric|min:0',
            'credit_days' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        $customer->update($validated);
        
        return redirect()->route('customers.index')
                        ->with('success', ucfirst($validated['type']) . ' updated successfully!');
    }

    public function export(Request $request)
    {
        $query = Customer::where('company_id', auth()->id());
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->get();
        
        $filename = "customers_vendors_" . date('Ymd') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel to recognize encoding correctly
            fputs($file, "\xEF\xBB\xBF");
            
            // headers as per the LATEST image
            fputcsv($file, [
                'CUSTOMER / VENDOR NAME', 
                'ADDRESS 1', 
                'ADDRESS 2', 
                'CITY', 
                'Pincode', 
                'mobile no', 
                'email'
            ]);

            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->business_name,
                    $customer->billing_address,
                    $customer->address_2,
                    $customer->city,
                    $customer->pincode,
                    $customer->phone,
                    $customer->email
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Customer $customer)
    {
        // Ensure the customer belongs to the authenticated company
        if ($customer->company_id !== auth()->id()) {
            abort(403);
        }
        
        $type = $customer->type;
        $customer->delete();
        
        return redirect()->route('customers.index')
                        ->with('success', ucfirst($type) . ' deleted successfully!');
    }
}

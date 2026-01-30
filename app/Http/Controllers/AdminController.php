<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Show admin login page
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Show admin dashboard with all companies
    public function dashboard()
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.dashboard', compact('companies'));
    }

    // View single company details
    public function viewCompany($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.company-details', compact('company'));
    }

    // Delete company
    public function deleteCompany($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Company deleted successfully.');
    }

    
    // Toggle company block status
    public function toggleBlock($id)
    {
        $company = Company::findOrFail($id);
        $company->is_blocked = !$company->is_blocked;
        $company->save();
        
        $status = $company->is_blocked ? 'blocked' : 'unblocked';
        return redirect()->route('admin.dashboard')->with('success', "Company has been {$status} successfully.");
    }

    // Update subscription dates
    public function updateSubscription(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        
        $request->validate([
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date|after_or_equal:subscription_start',
        ]);
        
        $company->subscription_start = $request->subscription_start;
        $company->subscription_end = $request->subscription_end;
        $company->save();
        
        return redirect()->route('admin.company.view', $id)->with('success', 'Subscription updated successfully.');
    }

    // Admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

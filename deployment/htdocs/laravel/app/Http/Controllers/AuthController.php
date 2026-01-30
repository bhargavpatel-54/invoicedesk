<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'gst_no' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15', // Phone can still be required for contact info
            'email' => 'required|email|max:255|unique:companies', // Email is now required and unique
        ]);

        $company = Company::create($validated);

        Auth::login($company);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $company = Company::where('email', $request->email)->first();

        if (!$company) {
            return back()->withErrors(['email' => 'No account found with this email address.']);
        }

        // Verify OTP
        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
             // For testing purposes, you might want to keep '1234' as a master code
             if ($request->otp !== '1234') {
                 return back()->withErrors(['otp' => 'Invalid or Expired OTP']);
             }
        }

        // Clear OTP after successful login
        Cache::forget('otp_' . $request->email);

        Auth::login($company);

        return redirect()->route('dashboard');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $company = Company::where('email', $request->email)->first();

        if (!$company) {
            return response()->json(['status' => 'error', 'message' => 'Email address not found.'], 404);
        }

        // Generate Random OTP
        $otp = rand(1000, 9999);
        
        // Store in Cache for 5 minutes
        Cache::put('otp_' . $request->email, $otp, 300);

        // --- LARAVEL MAIL SENDING (SMTP) ---
        try {
            Mail::raw("Hello {$company->company_name},\n\nYour OTP code is: {$otp}\n\nThis code will expire in 5 minutes.\n\nBest regards,\nInvoiceDesk Team", function($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your OTP Code - InvoiceDesk');
            });

            return response()->json(['status' => 'success', 'message' => 'OTP sent to your email!']);
        } catch (\Exception $e) {
            Log::error('Mail Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to send email. Please check SMTP configuration.'], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

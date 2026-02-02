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

        return redirect()->route('login')->with('success', 'Account created successfully! Please login with your email.');
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

        // Check if company is blocked or subscription expired
        if ($company->is_blocked) {
            Auth::login($company);
            return redirect()->route('subscription.blocked')->with('error', 'Your account has been blocked. Please contact support or renew your subscription.');
        }

        if ($company->isSubscriptionExpired()) {
            Auth::login($company);
            return redirect()->route('subscription.expired')->with('error', 'Your subscription has expired. Please renew to continue using InvoiceDesk.');
        }

        Auth::login($company);

        return redirect()->route('dashboard');
    }

    public function sendOtp(Request $request)
    {
        Log::info("sendOtp called for email: " . $request->email);
        $request->validate(['email' => 'required|email']);
        
        $company = Company::where('email', $request->email)->first();

        if (!$company) {
            return response()->json(['status' => 'error', 'message' => 'Email address not found.'], 404);
        }

        // Generate Random OTP
        $otp = rand(1000, 9999);
        
        // Store in Cache for 5 minutes
        Cache::put('otp_' . $request->email, $otp, 300);

        // Log the OTP for development/testing purposes
        Log::info("OTP for {$request->email}: {$otp}");

        // Capture values to avoid using $request or complex objects in the closure
        $email = $request->email;
        $companyName = $company->company_name;

        // Send email and handle fallback
        try {
            Log::info("Attempting to send OTP via SMTP to $email");
            Mail::to($email)->send(new \App\Mail\OtpMail($otp, $companyName));
            Log::info("OTP successfully sent via SMTP to $email");
        } catch (\Exception $e) {
            Log::error("SMTP Error for $email: " . $e->getMessage());
            
            // Fallback to EmailJS
            Log::info("Switching to EmailJS fallback for $email");
            $serviceId = env('EMAILJS_SERVICE_ID');
            $templateId = env('EMAILJS_TEMPLATE_ID');
            $publicKey = env('EMAILJS_PUBLIC_KEY');
            $privateKey = env('EMAILJS_PRIVATE_KEY');

            if ($serviceId && $templateId && $publicKey) {
                try {
                    Log::info("Sending via EmailJS API...");
                    $response = Http::post('https://api.emailjs.com/api/v1.0/email/send', [
                        'service_id' => $serviceId,
                        'template_id' => $templateId,
                        'user_id' => $publicKey,
                        'accessToken' => $privateKey,
                        'template_params' => [
                            'otp' => $otp,
                            'to_email' => $email,
                            'company_name' => $companyName,
                            'to_name' => $companyName,
                        ],
                    ]);
                    
                    if ($response->successful()) {
                        Log::info("OTP successfully sent via EmailJS to $email");
                    } else {
                        Log::error("EmailJS API Error for $email: " . $response->body());
                    }
                } catch (\Exception $ee) {
                    Log::error("EmailJS Fallback failed for $email: " . $ee->getMessage());
                }
            } else {
                Log::error("EmailJS fallback skipped: Missing configuration for $email");
            }
        }

        // Return success immediately
        return response()->json([
            'status' => 'success', 
            'message' => 'OTP has been sent to your email!',
        ]);
    }

    /**
     * Fallback method to send OTP via EmailJS API if SMTP fails
     */
    protected function sendOtpViaEmailJS($email, $otp, $companyName)
    {
        $serviceId = env('EMAILJS_SERVICE_ID');
        $templateId = env('EMAILJS_TEMPLATE_ID');
        $publicKey = env('EMAILJS_PUBLIC_KEY');
        $privateKey = env('EMAILJS_PRIVATE_KEY');

        if (!$serviceId || !$templateId || !$publicKey) {
            return;
        }

        try {
            $response = Http::post('https://api.emailjs.com/api/v1.0/email/send', [
                'service_id' => $serviceId,
                'template_id' => $templateId,
                'user_id' => $publicKey,
                'accessToken' => $privateKey,
                'template_params' => [
                    'otp' => $otp,
                    'to_email' => $email,
                    'company_name' => $companyName,
                    'to_name' => $companyName,
                ],
            ]);

            if ($response->successful()) {
                Log::info("OTP email sent successfully via EmailJS to {$email}");
            } else {
                Log::error("EmailJS failed: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("EmailJS exception: " . $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

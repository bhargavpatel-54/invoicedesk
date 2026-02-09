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

        $validated['email'] = strtolower($validated['email']);

        $company = Company::create($validated);

        return redirect()->route('login')->with('success', 'Account created successfully! Please login with your email.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $email = strtolower($request->email);
        $company = Company::where('email', $email)->first();

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
        try {
            $request->validate(['email' => 'required|email']);
            $email = strtolower($request->email);
            
            Log::info("sendOtp called for email: " . $email);
            
            $company = Company::where('email', $email)->first();

            if (!$company) {
                Log::warning("OTP requested for non-existent email: " . $email);
                return response()->json(['status' => 'error', 'message' => 'Email address not found.'], 404);
            }

            // Generate Random OTP
            $otp = rand(1000, 9999);
            // Cache OTP for 15 minutes (900 seconds) to match the email text and give users enough time
            Cache::put('otp_' . $email, $otp, 900);
            Log::info("Generated OTP for {$email}: {$otp}");

            $companyName = $company->company_name;
            $sentStatus = false;
            $errorMessage = '';

            // Detect environment
            $isRender = env('IS_RENDER') || config('app.env') === 'production';

            // 1. Attempt SMTP (Skip on Render if it's known to timeout)
            if (!$isRender) {
                try {
                    Log::info("Attempting to send OTP via SMTP to $email");
                    // Calculate expiry time for consistency (15 minutes from now)
                    $validTill = now()->addMinutes(15)->format('h:i A');
                    Mail::to($email)->send(new \App\Mail\OtpMail($otp, $companyName, $validTill));
                    Log::info("OTP successfully sent via SMTP to $email");
                    $sentStatus = true;
                } catch (\Exception $e) {
                    $errorMessage = "SMTP Error: " . $e->getMessage();
                    Log::error("SMTP Error for $email: " . $e->getMessage());
                    // Fallback will happen below
                }
            } else {
                Log::info("Skipping SMTP on Render for $email, using EmailJS directly.");
            }

            // 2. Fallback to EmailJS (or Primary if on Render)
            if (!$sentStatus) {
                Log::info("Attempting EmailJS for $email");
                $result = $this->sendOtpViaEmailJS($email, $otp, $companyName);
                if ($result['success']) {
                    $sentStatus = true;
                } else {
                    $errorMessage .= ($errorMessage ? ' | ' : '') . "EmailJS Error: " . $result['message'];
                }
            }

            if ($sentStatus) {
                return response()->json([
                    'status' => 'success', 
                    'message' => 'OTP has been sent to your email!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send OTP. ' . $errorMessage . '. Please check your configuration.',
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error("General error in sendOtp: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'A server error occurred: ' . $e->getMessage(),
            ], 500);
        }
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
            return ['success' => false, 'message' => 'Missing EmailJS configuration'];
        }

        try {
            // Calculate expiry time (15 minutes from now)
            $validTill = now()->addMinutes(15)->format('h:i A');

            $response = Http::post('https://api.emailjs.com/api/v1.0/email/send', [
                'service_id' => $serviceId,
                'template_id' => $templateId,
                'user_id' => $publicKey,
                'accessToken' => $privateKey,
                'template_params' => [
                    'otp' => $otp,
                    'to_email' => $email,
                    'email' => $email, // Some templates use 'email'
                    'company_name' => $companyName,
                    'to_name' => $companyName,
                    'valid_till' => $validTill,
                ],
            ]);

            if ($response->successful()) {
                Log::info("OTP email sent successfully via EmailJS to {$email}");
                return ['success' => true];
            } else {
                Log::error("EmailJS failed: " . $response->body());
                return ['success' => false, 'message' => $response->body()];
            }
        } catch (\Exception $e) {
            Log::error("EmailJS exception: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOtpEmail implements ShouldQueue
{
    use Queueable;

    public $email;
    public $companyName;
    public $otp;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $companyName, $otp)
    {
        $this->email = $email;
        $this->companyName = $companyName;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::raw("Hello {$this->companyName},\n\nYour OTP code is: {$this->otp}\n\nThis code will expire in 5 minutes.\n\nBest regards,\nInvoiceDesk Team", function($message) {
                $message->to($this->email)
                        ->subject('Your OTP Code - InvoiceDesk');
            });
            
            Log::info("OTP email sent successfully to {$this->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email to {$this->email}: " . $e->getMessage());
            // Job will be retried automatically based on queue configuration
        }
    }
}

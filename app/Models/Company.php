<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'company_name',
        'gst_no',
        'address',
        'phone',
        'email',
        'is_blocked',
        'subscription_start',
        'subscription_end',
        'business_type',
        'financial_year_start_month',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'subscription_start' => 'date',
        'subscription_end' => 'date',
    ];

    /**
     * Check if subscription is expired
     */
    public function isSubscriptionExpired()
    {
        if (!$this->subscription_end) {
            return false; // No subscription end date means unlimited or not set
        }
        return now()->greaterThan($this->subscription_end);
    }

    /**
     * Check if company is active (not blocked and subscription not expired)
     */
    public function isActive()
    {
        return !$this->is_blocked && !$this->isSubscriptionExpired();
    }

    /**
     * Get remaining days in subscription
     */
    public function getRemainingDays()
    {
        if (!$this->subscription_end) {
            return null;
        }
        return (int) now()->diffInDays($this->subscription_end, false);
    }

    /**
     * Get business type label
     */
    public function getBusinessTypeLabel()
    {
        return match($this->business_type) {
            'manufacturer' => 'Manufacturer',
            'retailer' => 'Retailer',
            'wholesaler' => 'Wholesaler',
            default => 'Retailer'
        };
    }

    /**
     * Check if manufacturer
     */
    public function isManufacturer()
    {
        return $this->business_type === 'manufacturer';
    }

    /**
     * Check if retailer
     */
    public function isRetailer()
    {
        return $this->business_type === 'retailer';
    }

    /**
     * Check if wholesaler
     */
    public function isWholesaler()
    {
        return $this->business_type === 'wholesaler';
    }
}

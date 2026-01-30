<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\SaleInvoice;
use App\Models\Company;

class UniqueInvoiceNumberInFinancialYear implements ValidationRule
{
    protected $companyId;
    protected $invoiceDate;
    protected $excludeInvoiceId;

    /**
     * Create a new rule instance.
     *
     * @param int $companyId
     * @param string $invoiceDate
     * @param int|null $excludeInvoiceId Invoice ID to exclude (for updates)
     */
    public function __construct($companyId, $invoiceDate, $excludeInvoiceId = null)
    {
        $this->companyId = $companyId;
        $this->invoiceDate = $invoiceDate;
        $this->excludeInvoiceId = $excludeInvoiceId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Get company to determine financial year start month
        $company = Company::find($this->companyId);
        $fyStartMonth = $company->financial_year_start_month ?? 4;
        
        // Calculate current financial year based on invoice date
        $invoiceDate = \Carbon\Carbon::parse($this->invoiceDate);
        $currentMonth = $invoiceDate->month;
        $currentYear = $invoiceDate->year;
        
        // If current month is before FY start month, we're in the previous FY
        if ($currentMonth < $fyStartMonth) {
            $fyStartYear = $currentYear - 1;
            $fyEndYear = $currentYear;
        } else {
            $fyStartYear = $currentYear;
            $fyEndYear = $currentYear + 1;
        }
        
        // Create FY start and end dates
        $fyStart = \Carbon\Carbon::create($fyStartYear, $fyStartMonth, 1)->startOfDay();
        $fyEnd = \Carbon\Carbon::create($fyEndYear, $fyStartMonth, 1)->subDay()->endOfDay();
        
        // Check if invoice number already exists in this financial year
        $query = SaleInvoice::where('company_id', $this->companyId)
                            ->where('invoice_number', $value)
                            ->whereBetween('invoice_date', [$fyStart, $fyEnd]);
        
        // Exclude current invoice if updating
        if ($this->excludeInvoiceId) {
            $query->where('id', '!=', $this->excludeInvoiceId);
        }
        
        if ($query->exists()) {
            $fail("Invoice number {$value} already exists in the current financial year ({$fyStartYear}-" . substr($fyEndYear, -2) . ").");
        }
    }
}

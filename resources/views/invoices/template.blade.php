<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tax Invoice</title>

@php
    if (!function_exists('amountToWords')) {
        function amountToWords($number) {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = array();
            $words = array(0 => '', 1 => 'ONE', 2 => 'TWO',
                3 => 'THREE', 4 => 'FOUR', 5 => 'FIVE', 6 => 'SIX',
                7 => 'SEVEN', 8 => 'EIGHT', 9 => 'NINE',
                10 => 'TEN', 11 => 'ELEVEN', 12 => 'TWELVE',
                13 => 'THIRTEEN', 14 => 'FOURTEEN', 15 => 'FIFTEEN',
                16 => 'SIXTEEN', 17 => 'SEVENTEEN', 18 => 'EIGHTEEN',
                19 => 'NINETEEN', 20 => 'TWENTY',
                30 => 'THIRTY', 40 => 'FORTY', 50 => 'FIFTY',
                60 => 'SIXTY', 70 => 'SEVENTY',
                80 => 'EIGHTY', 90 => 'NINETY');
            $digits = array('', 'HUNDRED','THOUSAND','LAKH', 'CRORE');
            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 19) ? 'S' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' AND ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = ($decimal > 0) ? " AND " . ($words[floor($decimal / 10) * 10] . " " . $words[$decimal % 10]) . ' PAISE' : '';
            return ($Rupees ? $Rupees . 'RUPEES ' : '') . $paise . ' ONLY';
        }
    }

    $companyStateCode = substr($invoice->company->gst_no ?? '00', 0, 2);
    $customerStateCode = substr($invoice->customer->gst_no ?? '00', 0, 2);
    $isInterState = $companyStateCode !== $customerStateCode;
@endphp

<style>
/* ================= A4 PAGE SETUP ================= */
@page {
    size: A4;
    margin: 8mm 10mm;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    width: 210mm;
    height: 297mm;
    margin: 0 auto;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    line-height: 1.4;
    color: #000;
    background: #f5f5f5;
}

.page {
    width: 190mm;
    min-height: 277mm;
    padding: 6mm;
    margin: 0 auto;
    background: white;
    position: relative;
    box-sizing: border-box;
}

/* ================= TABLES ================= */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

td, th {
    border: 1px solid #000;
    padding: 4px 6px;
    vertical-align: top;
    font-size: 14px;
}

th {
    font-weight: bold;
    text-align: center;
    background: #f5f5f5;
}

.no-border {
    border: none;
}

.no-border td {
    border: none;
    padding: 2px 4px;
}

/* ================= UTILITIES ================= */
.bold { font-weight: bold; }
.center { text-align: center; }
.right { text-align: right; }
.left { text-align: left; }
.small { font-size: 12px; }
.large { font-size: 16px; }
.xlarge { font-size: 22px; }

/* ================= HEADER STYLES ================= */
.company-logo {
    font-size: 32pt;
    font-weight: 900;
    color: #003087;
    letter-spacing: -2px;
    line-height: 1;
}

.company-name {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 2px;
}

.company-address {
    font-size: 16px;
    line-height: 1.4;
}

.header-line {
    border-top: 2px solid #000;
    border-bottom: 1px solid #000;
    margin: 2mm 0;
    padding: 2px 0;
    font-size: 11px;
    text-align: center;
}

/* ================= INVOICE INFO BOX ================= */
.info-box {
    background: #e8e8e8;
    padding: 3px 6px;
    margin: 2mm 0;
}

.info-label {
    font-weight: bold;
    font-size: 12px;
}

/* ================= PRODUCT TABLE ================= */
.product-table th {
    padding: 4px 4px;
    font-size: 13px;
    font-weight: bold;
}

.product-table td {
    padding: 3px 4px;
    font-size: 13px;
}

.product-table .item-desc {
    text-align: left;
}

/* ================= SUMMARY TABLE ================= */
.summary-table td {
    padding: 3px 6px;
    font-size: 14px;
}

.summary-total {
    font-weight: bold;
    font-size: 16px;
}

/* ================= BANK & TERMS ================= */
.bank-details {
    font-size: 14px;
    line-height: 1.5;
}

.terms-text {
    font-size: 13px;
    line-height: 1.5;
}

.qr-placeholder {
    width: 80px;
    height: 80px;
    border: 1px solid #000;
    display: inline-block;
    background: #f0f0f0;
}

/* ================= SIGNATURE ================= */
.signature-box {
    text-align: center;
    padding-top: 20px;
    font-size: 14px;
}

/* Page break control */
table, tr, td, th, tbody, thead {
    page-break-inside: avoid !important;
}
</style>
</head>

<body>
<div class="page">

<!-- ================= HEADER WITH LOGO ================= -->
<table class="no-border" style="margin-bottom: 1mm;">
<tr>
<td style="width: 15%; vertical-align: top;">
    @if($invoice->company->logo)
        <img src="{{ public_path($invoice->company->logo) }}" style="max-height: 50px; max-width: 100%;">
    @else
        <div class="company-logo">FOX</div>
    @endif
</td>
<td style="width: 55%; vertical-align: top; padding-left: 8px;">
    <div class="company-name" style="text-transform: uppercase;">{{ $invoice->company->company_name }}</div>
    <div class="company-address">
        {{ $invoice->company->slogan ?? 'Your Trusted Partner in Excellence' }}
        
    </div>
</td>
<td style="width: 30%; vertical-align: top; text-align: right;">
    <div style="font-size: 14px;">
        <b>PH:</b> {{ $invoice->company->phone }}<br>
        <b>EMAIL:</b> {{ $invoice->company->email }}
    </div>
</td>
</tr>
</table>

<!-- ================= ADDRESS LINE ================= -->
<div class="header-line">
    {{ $invoice->company->address }}
</div>

<!-- ================= GSTIN & INVOICE TYPE ================= -->
<table style="margin-bottom: 1mm; ">
<tr>
<td style="width: 34%; padding: 5px 7px;">
    <b style="font-size: 13px;">GSTIN : <span style="text-transform: uppercase;">{{ $invoice->company->gst_no }}</span></b>
</td>
<td style="width: 32%; padding: 5px 7px; text-align: center; background: #e8e8e8;">
    <b style="font-size: 18px;">TAX INVOICE</b>
</td>
<td style="width: 33%; padding: 5px 7px; text-align: right;">
    <b style="font-size: 13px;">ORIGINAL FOR RECIPIENT</b>
</td>
</tr>
</table>

<!-- ================= BUYER & INVOICE INFO ================= -->
<table style="margin-bottom: 1mm;">
<tr>
<td style="width: 60%; padding: 7px; font-size: 14px;">
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Name:</b> <span style="text-transform: uppercase;">{{ $invoice->customer->business_name }}</span></div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Address:</b> {{ $invoice->customer->billing_address }}</div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">PHONE:</b> {{ $invoice->customer->phone ?? 'N/A' }}</div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Email:</b> {{ $invoice->customer->email ?? 'N/A' }}</div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">GSTIN:</b> <span style="text-transform: uppercase;">{{ $invoice->customer->gst_no ?? 'Unregistered' }}</span></div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Place of Supply:</b> {{ $invoice->customer->state }} ({{ substr($invoice->customer->gst_no ?? '00', 0, 2) }})</div>
</td>
<td style="width: 40%; padding: 7px; font-size: 14px;">
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Invoice No.:</b> {{ $invoice->invoice_number }}</div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Dated:</b> {{ $invoice->invoice_date->format('d-M-Y') }}</div>
    <div style="margin-bottom: 4px;"><b style="font-size: 12px;">Due Date:</b> {{ $invoice->due_date ? $invoice->due_date->format('d-M-Y') : '-' }}</div>
</td>
</tr>
</table>

<!-- ================= PRODUCT TABLE ================= -->
<table class="product-table" style="margin-bottom: 1mm;">
<thead>
<tr>
    <th style="width: 4%;">S.<br>No.</th>
    <th style="width: 35%;">Name of Product/ Service</th>
    <th style="width: 9%;">HSN/ SAC</th>
    <th style="width: 7%;">Qty<br>({{ $invoice->items->first()->product->unit ?? $invoice->items->first()->unit ?? 'Units' }})</th>
    <th style="width: 9%;">Rate</th>
    <th style="width: 11%;">Taxable Value</th>
    @if($isInterState)
    <th style="width: 10%;">IGST<br>%</th>
    <th style="width: 10%;">IGST<br>Amt</th>
    @else
    <th style="width: 7%;">CGST<br>%</th>
    <th style="width: 7%;">SGST<br>%</th>
    @endif
    <th style="width: 8%;">Total</th>
</tr>
</thead>
<tbody>
@php
    $rowCount = count($invoice->items);
    $minRows = 8;
@endphp

@foreach($invoice->items as $i => $item)
<tr>
    <td class="center">{{ $i+1 }}</td>
    <td class="item-desc">{{ $item->product->name }}</td>
    <td class="center">{{ $item->hsn_code ?? $item->product->hsn_code }}</td>
    <td class="center">{{ number_format($item->quantity, 2) }}</td>
    <td class="right">{{ number_format($item->rate, 2) }}</td>
    <td class="right">{{ number_format($item->taxable_amount, 2) }}</td>
    @if($isInterState)
    <td class="center">{{ $item->tax_rate }}%</td>
    <td class="right">{{ number_format($item->tax_amount, 2) }}</td>
    @else
    <td class="center">{{ $item->tax_rate/2 }}%</td>
    <td class="center">{{ $item->tax_rate/2 }}%</td>
    @endif
    <td class="right"><b>{{ number_format($item->total_amount, 2) }}</b></td>
</tr>
@endforeach

{{-- EMPTY ROWS TO FILL PAGE --}}
@for($i = $rowCount; $i < $minRows; $i++)
<tr>
    <td class="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    @if($isInterState)
    <td></td>
    <td></td>
    @else
    <td></td>
    <td></td>
    @endif
    <td></td>
</tr>
@endfor

{{-- SUBTOTAL ROW --}}
<tr style="background: #f0f0f0;">
    <td colspan="3" class="right"><b>SUBTOTAL</b></td>
    <td class="center"><b>{{ number_format($invoice->items->sum('quantity'), 2) }}</b></td>
    <td></td>
    <td class="right"><b>{{ number_format($invoice->items->sum('taxable_amount'), 2) }}</b></td>
    @if($isInterState)
    <td></td>
    <td class="right"><b>{{ number_format($invoice->tax_amount, 2) }}</b></td>
    @else
    <td></td>
    <td></td>
    @endif
    <td class="right"><b>₹ {{ number_format($invoice->total_amount, 2) }}</b></td>
</tr>
</tbody>
</table>

<!-- ================= AMOUNT IN WORDS ================= -->
<table style="margin-bottom: 1mm;">
<tr>
<td style="padding: 7px; font-size: 14px;">
    <b>Total in words</b><br>
    <span style="text-transform: uppercase;">{{ amountToWords($invoice->total_amount) }}</span>
</td>
</tr>
</table>

<!-- ================= TAX SUMMARY & BANK DETAILS ================= -->
<table style="margin-bottom: 1mm;">
<tr>
<td style="width: 50%; padding: 6px; vertical-align: top;">
    <div class="bank-details">
        
        
        <div style="margin-top: 8px;">
            <b>Bank Details</b><br>
            <b>Bank Name:</b> {{ $invoice->company->bank_name ?? 'Kotak Mahindra Bank' }}<br>
            <b>Branch:</b> {{ $invoice->company->branch ?? 'City Center' }}<br>
            <b>Account Number:</b> {{ $invoice->company->account_number ?? '123654789321' }}<br>
            <b>IFSC:</b> {{ $invoice->company->ifsc_code ?? 'KKBK0000888' }}
        </div>
    </div>
</td>
<td style="width: 50%; padding: 6px; vertical-align: top;">
    <table class="summary-table">
        <tr>
            <td><b>Taxable Value</b></td>
            <td class="right">{{ number_format($invoice->items->sum('taxable_amount'), 2) }}</td>
        </tr>
        @if($isInterState)
        <tr>
            <td><b>IGST</b></td>
            <td class="right">{{ number_format($invoice->tax_amount, 2) }}</td>
        </tr>
        @else
        <tr>
            <td><b>CGST</b></td>
            <td class="right">{{ number_format($invoice->tax_amount / 2, 2) }}</td>
        </tr>
        <tr>
            <td><b>SGST</b></td>
            <td class="right">{{ number_format($invoice->tax_amount / 2, 2) }}</td>
        </tr>
        @endif
        @if($invoice->shipping_charges > 0)
        <tr>
            <td><b>Shipping Charges</b></td>
            <td class="right">{{ number_format($invoice->shipping_charges, 2) }}</td>
        </tr>
        @endif
        <tr style="background: #e8e8e8;">
            <td class="summary-total"><b>Total</b></td>
            <td class="right summary-total"><b>₹ {{ number_format($invoice->total_amount, 2) }}</b></td>
        </tr>
    </table>

</td>
</tr>
</table>

<!-- ================= TERMS & CONDITIONS ================= -->
<table style="margin-bottom: 1mm;">
<tr>
<td style="width: 58%; padding: 6px; vertical-align: top;">
    <div class="terms-text">
        <b>Terms and Conditions</b><br>
        Subject to our Name Mentioned.<br>
        Our Responsibility Ceases as soon as goods leaves our Premises.<br>
        Goods once sold will not be taken back.<br>
        Delivery: Ex-Premises.
    </div>
</td>
<td style="width: 42%; padding: 0; vertical-align: top;">
    <!-- Upper Box: Company Name -->
    <div style="border: 1px solid #000; border-bottom: none; padding: 8px; text-align: center; font-size: 14px;">
        <b>For <span style="text-transform: uppercase;">{{ $invoice->company->company_name }}</span></b>
    </div>
    
    <!-- Middle Box: Signature Space -->
    <div style="border: 1px solid #000; border-bottom: none; padding: 35px 10px; min-height: 70px; background: white;">
        <!-- Empty space for signature -->
    </div>
    
    <!-- Lower Box: Authorised Signatory -->
    <div style="border: 1px solid #000; padding: 8px; text-align: center; font-size: 14px;">
        <b>Authorised Signatory</b>
    </div>
</td>
</tr>
</table>

<!-- ================= FOOTER ================= -->
<div style="text-align: center; font-size: 13px; margin-top: 2mm; border-top: 1px solid #ccc; padding-top: 1mm;">
    This is a computer generated invoice and does not require a physical signature.
</div>

</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            min-height: 100vh;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 210mm;
            margin: 0 auto 20px auto;
            padding: 0 10px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .invoice-container {
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            max-width: 210mm;
            margin: 0 auto;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .top-bar {
                display: none !important;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar with Buttons - Hidden if in iframe -->
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('in-iframe');
        }
    </script>
    <style>
        .in-iframe .top-bar { display: none !important; }
        .in-iframe body { padding: 0 !important; background: white !important; }
        .in-iframe .invoice-container { box-shadow: none !important; border-radius: 0 !important; }
    </style>

    <div class="top-bar">
        <!-- Left Side: Back Button -->
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary btn-lg shadow">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
        
        <!-- Right Side: Action Buttons -->
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-primary btn-lg shadow">
                <i class="bi bi-printer-fill me-2"></i>Print
            </button>
            <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-lg shadow">
                <i class="bi bi-download me-2"></i>Download PDF
            </a>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="invoice-container">
        @include('invoices.template')
    </div>
</body>
</html>

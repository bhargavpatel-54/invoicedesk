<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .otp-container {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-label {
            font-size: 14px;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 700;
            color: #667eea;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        .expiry-notice {
            font-size: 13px;
            color: #999999;
            margin-top: 10px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-text {
            font-size: 14px;
            color: #856404;
            margin: 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer-text {
            font-size: 13px;
            color: #6c757d;
            margin: 5px 0;
        }
        .brand {
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🔐 InvoiceDesk</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $companyName }},
            </div>
            
            <div class="message">
                You have requested to log in to your InvoiceDesk account. Please use the One-Time Password (OTP) below to complete your login:
            </div>
            
            <div class="otp-container">
                <div class="otp-label">Your OTP Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="expiry-notice">⏱️ This code will expire in 5 minutes</div>
            </div>
            
            <div class="warning">
                <p class="warning-text">
                    <strong>⚠️ Security Notice:</strong> Never share this OTP with anyone. InvoiceDesk will never ask you for this code via phone or email.
                </p>
            </div>
            
            <div class="message">
                If you didn't request this code, please ignore this email or contact our support team if you have concerns about your account security.
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                <strong class="brand">InvoiceDesk</strong> - Your Complete Billing Solution
            </p>
            <p class="footer-text">
                © {{ date('Y') }} InvoiceDesk. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

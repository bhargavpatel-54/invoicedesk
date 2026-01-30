<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InvoiceDesk - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-screen w-full flex overflow-hidden">

    <!-- Left Side (Green Background with Floating Bubbles) -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#00C853] relative items-center justify-center overflow-hidden">
        
        <!-- Background Circles Pattern (Subtle) -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="circles" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                        <circle cx="30" cy="30" r="20" stroke="white" stroke-width="2" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#circles)" />
            </svg>
        </div>

        <!-- Dashboard Image Mockup -->
        <div class="relative z-10 w-4/5 max-w-2xl transform translate-y-12">
             <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Preview" class="rounded-xl shadow-2xl border-4 border-white/20" style="width: 80%; height: 300px; margin-bottom: 70px; margin-left: 40px;">
        </div>

        <!-- Floating Feature Bubbles -->
        <!-- Top Center - Sale Invoice -->
        <div class="absolute top-12 left-1/2 transform -translate-x-1/2 bg-white/20 backdrop-blur-md rounded-full px-6 py-3 flex items-center gap-3 border border-white/30 text-white shadow-lg animate-bounce-slow" style="animation-duration: 4s;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="font-medium whitespace-nowrap">Sale Invoice</span>
        </div>

        <!-- Top Left - Purchase Invoice -->
        <div class="absolute top-32 left-12 bg-white/20 backdrop-blur-md rounded-full px-5 py-3 flex items-center gap-2 border border-white/30 text-white shadow-lg delay-700 animate-bounce-slow" style="animation-duration: 5s;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="font-medium whitespace-nowrap">Purchase Invoice</span>
        </div>

        <!-- Top Right - GST Report -->
        <div class="absolute top-32 right-12 bg-white/20 backdrop-blur-md rounded-full px-5 py-3 flex items-center gap-2 border border-white/30 text-white shadow-lg delay-1000 animate-bounce-slow" style="animation-duration: 4.5s;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="font-medium whitespace-nowrap">GST Report</span>
        </div>

        <!-- Bottom Left - Track Payment -->
        <div class="absolute bottom-32 left-12 bg-white/20 backdrop-blur-md rounded-full px-5 py-3 flex items-center gap-2 border border-white/30 text-white shadow-lg delay-500 animate-bounce-slow" style="animation-duration: 5.5s;">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium whitespace-nowrap">Track Payment</span>
        </div>

        <!-- Bottom Center - Email & SMS -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 bg-white/20 backdrop-blur-md rounded-full px-6 py-3 flex items-center gap-2 border border-white/30 text-white shadow-lg animate-bounce-slow" style="animation-duration: 4.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="font-medium whitespace-nowrap">Email & SMS</span>
        </div>

        <!-- Bottom Right - Delivery Challan -->
        <div class="absolute bottom-32 right-12 bg-white/20 backdrop-blur-md rounded-full px-5 py-3 flex items-center gap-2 border border-white/30 text-white shadow-lg delay-300 animate-bounce-slow" style="animation-duration: 4.8s;">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
            </svg>
            <span class="font-medium whitespace-nowrap">Delivery Challan</span>
        </div>
    </div>

    <!-- Right Side (Login Form) -->
    <div class="w-full lg:w-1/2 bg-white p-8 overflow-y-auto h-full">
        <div class="w-full max-w-md space-y-8 mx-auto min-h-full flex flex-col justify-center py-10">
            <!-- Logo Section -->
            <div class="text-left mb-10">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <span class="text-green-600">Invoice</span>Desk
                </h1>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <h2 class="text-3xl font-semibold text-gray-800">Login</h2>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-lg text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div id="otp-message" class="hidden p-4 rounded-lg text-sm"></div>
                
                <!-- Email Input -->
                <div class="relative group">
                    <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email Address<span class="text-red-500">*</span></label>
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-gray-50 focus-within:ring-2 focus-within:ring-green-500 focus-within:border-transparent transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full p-3 bg-gray-50 outline-none text-gray-700 placeholder-gray-400" placeholder="your@email.com" required>
                    </div>
                </div>
                
                <!-- Send OTP Button -->
                <div class="flex justify-end -mt-2">
                    <button type="button" id="send-otp-btn" class="px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-600 hover:text-white hover:border-emerald-600 hover:shadow-md transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-sm" style="background-color: #00d084; border-color: #00d084; color: white;">
                        Send OTP
                    </button>
                </div>

                <!-- OTP Input -->
                <div class="relative group">
                    <label for="otp" class="block text-sm font-medium text-gray-500 mb-1">OTP<span class="text-red-500">*</span></label>
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-gray-50 focus-within:ring-2 focus-within:ring-green-500 focus-within:border-transparent transition-all">
                        <input type="text" id="otp" name="otp" class="w-full p-3 bg-gray-50 outline-none text-gray-700 placeholder-gray-400" placeholder="Enter OTP">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Login
                    </button>
                    <button type="button" onclick="window.location.href='/register'" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create New Account
                    </button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('send-otp-btn').addEventListener('click', function() {
                const email = document.getElementById('email').value;
                const messageDiv = document.getElementById('otp-message');
                const btn = this;
                
                if (!email) {
                    messageDiv.textContent = 'Please enter an email address first.';
                    messageDiv.className = 'bg-red-50 text-red-500 p-4 rounded-lg text-sm mb-4 block';
                    return;
                }

                // Disable button
                btn.disabled = true;
                btn.textContent = 'Sending...';

                fetch('{{ route("send.otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    messageDiv.textContent = data.message;
                    if (data.status === 'success') {
                        messageDiv.className = 'bg-green-50 text-green-600 p-4 rounded-lg text-sm mb-4 block';
                        // Keep 1234 hint for testing
                        if(data.status === 'success') {
                            alert('OTP Sent to Email! (Use 1234 for testing)');
                        }
                    } else {
                        messageDiv.className = 'bg-red-50 text-red-500 p-4 rounded-lg text-sm mb-4 block';
                    }
                    btn.disabled = false;
                    btn.textContent = 'Send OTP';
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.textContent = 'An error occurred. Please try again.';
                    messageDiv.className = 'bg-red-50 text-red-500 p-4 rounded-lg text-sm mb-4 block';
                    btn.disabled = false;
                    btn.textContent = 'Send OTP';
                });
            });
        </script>

        <!-- Copyright -->
        <div class="absolute bottom-4 text-center text-xs text-gray-500 w-full lg:w-1/2 left-0 lg:left-auto">
            Copyright © 2026 InvoiceDesk - Best GST Billing Software. All rights reserved.
        </div>
    </div>

    <!-- Custom CSS for bounce animation -->
    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow infinite ease-in-out;
        }
    </style>
</body>
</html>

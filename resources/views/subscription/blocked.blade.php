<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Blocked - InvoiceDesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-pink-600 p-8 text-center text-white">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Account Blocked</h1>
                <p class="text-red-100">Your account has been temporarily blocked</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Your Account is Blocked</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Your InvoiceDesk account has been blocked by the administrator. This could be due to:
                    </p>
                    <ul class="text-left text-gray-600 space-y-2 max-w-md mx-auto mb-6">
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Expired subscription not renewed</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Violation of terms of service</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Pending payment issues</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Administrative action required</span>
                        </li>
                    </ul>
                </div>

                <!-- Renew Subscription Option -->
                <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 text-center">Renew Your Subscription</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">
                        If your account was blocked due to subscription expiry, you can renew it now to regain access.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <!-- Monthly -->
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                            <h4 class="font-bold text-gray-800">Monthly</h4>
                            <p class="text-2xl font-bold text-red-600 my-2">₹499</p>
                            <p class="text-xs text-gray-500">/month</p>
                        </div>
                        
                        <!-- Yearly -->
                        <div class="bg-white border-2 border-red-500 rounded-lg p-4 text-center relative">
                            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2">
                                <span class="bg-red-500 text-white px-3 py-0.5 rounded-full text-xs font-bold">SAVE 17%</span>
                            </div>
                            <h4 class="font-bold text-gray-800">Yearly</h4>
                            <p class="text-2xl font-bold text-red-600 my-2">₹4,999</p>
                            <p class="text-xs text-gray-500">/year</p>
                        </div>
                        
                        <!-- Lifetime -->
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                            <h4 class="font-bold text-gray-800">Lifetime</h4>
                            <p class="text-2xl font-bold text-red-600 my-2">₹9,999</p>
                            <p class="text-xs text-gray-500">one-time</p>
                        </div>
                    </div>

                    <button onclick="alert('Payment gateway integration coming soon!')" class="w-full mt-4 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-[1.02] transition-all">
                        Renew Subscription Now
                    </button>
                </div>

                <!-- Contact Support -->
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-1">Need Assistance?</h4>
                            <p class="text-sm text-blue-800 mb-2">
                                If you believe this is a mistake or need help resolving this issue, please contact our support team.
                            </p>
                            <div class="flex flex-wrap gap-3 text-sm">
                                <a href="mailto:support@invoicedesk.com" class="flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    support@invoicedesk.com
                                </a>
                                <a href="tel:+919876543210" class="flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    +91 98765 43210
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Company Info -->
        <div class="mt-6 bg-white/70 rounded-xl p-4 text-center">
            <p class="text-sm text-gray-600">
                Account: <strong>{{ Auth::user()->company_name }}</strong> ({{ Auth::user()->email }})
            </p>
        </div>
    </div>

</body>
</html>

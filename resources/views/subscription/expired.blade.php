<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired - InvoiceDesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-50 to-red-50 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-8 text-center text-white">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Subscription Expired</h1>
                <p class="text-orange-100">Your InvoiceDesk subscription has expired</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Renew Your Subscription</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Your subscription ended on <strong>{{ Auth::user()->subscription_end->format('d M Y') }}</strong>. 
                        To continue using InvoiceDesk and access all your invoices and data, please renew your subscription.
                    </p>
                </div>

                <!-- Subscription Plans -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <!-- Monthly Plan -->
                    <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-orange-500 hover:shadow-lg transition-all cursor-pointer">
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Monthly</h3>
                            <div class="mb-4">
                                <span class="text-3xl font-bold text-orange-600">₹499</span>
                                <span class="text-gray-500">/month</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                <li>✓ Unlimited Invoices</li>
                                <li>✓ GST Reports</li>
                                <li>✓ Email Support</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Yearly Plan (Popular) -->
                    <div class="border-2 border-orange-500 rounded-xl p-6 shadow-xl relative transform scale-105">
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                            <span class="bg-orange-500 text-white px-4 py-1 rounded-full text-xs font-bold">POPULAR</span>
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Yearly</h3>
                            <div class="mb-4">
                                <span class="text-3xl font-bold text-orange-600">₹4,999</span>
                                <span class="text-gray-500">/year</span>
                                <p class="text-xs text-green-600 mt-1">Save 17%</p>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                <li>✓ All Monthly Features</li>
                                <li>✓ Priority Support</li>
                                <li>✓ Free Updates</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Lifetime Plan -->
                    <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-orange-500 hover:shadow-lg transition-all cursor-pointer">
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Lifetime</h3>
                            <div class="mb-4">
                                <span class="text-3xl font-bold text-orange-600">₹9,999</span>
                                <span class="text-gray-500 text-sm block mt-1">One-time payment</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                <li>✓ All Features</li>
                                <li>✓ Lifetime Access</li>
                                <li>✓ Premium Support</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Payment Options -->
                <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Choose Your Payment Method</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <button class="bg-white border-2 border-gray-200 hover:border-orange-500 rounded-lg p-3 transition-all">
                            <div class="text-center">
                                <div class="text-2xl mb-1">💳</div>
                                <p class="text-xs font-medium">Credit Card</p>
                            </div>
                        </button>
                        <button class="bg-white border-2 border-gray-200 hover:border-orange-500 rounded-lg p-3 transition-all">
                            <div class="text-center">
                                <div class="text-2xl mb-1">🏦</div>
                                <p class="text-xs font-medium">UPI</p>
                            </div>
                        </button>
                        <button class="bg-white border-2 border-gray-200 hover:border-orange-500 rounded-lg p-3 transition-all">
                            <div class="text-center">
                                <div class="text-2xl mb-1">🌐</div>
                                <p class="text-xs font-medium">Net Banking</p>
                            </div>
                        </button>
                        <button class="bg-white border-2 border-gray-200 hover:border-orange-500 rounded-lg p-3 transition-all">
                            <div class="text-center">
                                <div class="text-2xl mb-1">💰</div>
                                <p class="text-xs font-medium">Wallet</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button onclick="alert('Payment gateway integration coming soon!')" class="flex-1 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition-all">
                        Proceed to Payment
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-xl transition-all">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Contact Support -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Need help? <a href="mailto:support@invoicedesk.com" class="text-orange-600 hover:text-orange-700 font-medium">Contact Support</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Company Info -->
        <div class="mt-6 bg-white/70 rounded-xl p-4 text-center">
            <p class="text-sm text-gray-600">
                Logged in as: <strong>{{ Auth::user()->company_name }}</strong> ({{ Auth::user()->email }})
            </p>
        </div>
    </div>

</body>
</html>

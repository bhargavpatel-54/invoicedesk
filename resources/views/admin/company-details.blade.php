<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Details - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-blue-600 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Company Details</h1>
                    <p class="text-purple-100 text-sm">View complete company information</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        
        <div class="max-w-4xl mx-auto">
            <!-- Company Info Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">{{ $company->company_name }}</h2>
                    <p class="text-gray-600 text-sm mt-1">Registered on {{ $company->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Company Name -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Company Name</label>
                            <p class="text-lg text-gray-900 font-medium">{{ $company->company_name }}</p>
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Email Address</label>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-lg text-gray-900">{{ $company->email }}</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Phone Number</label>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <p class="text-lg text-gray-900">{{ $company->phone }}</p>
                            </div>
                        </div>

                        <!-- GST Number -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">GST Number</label>
                            <p class="text-lg text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded-lg inline-block">{{ $company->gst_no }}</p>
                        </div>

                        <!-- Address -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Address</label>
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-lg text-gray-900 leading-relaxed">{{ $company->address }}</p>
                            </div>
                        </div>

                        <!-- Created At -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Registration Date</label>
                            <p class="text-lg text-gray-900">{{ $company->created_at->format('d M Y, h:i A') }}</p>
                            <p class="text-sm text-gray-500">{{ $company->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- Updated At -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Last Updated</label>
                            <p class="text-lg text-gray-900">{{ $company->updated_at->format('d M Y, h:i A') }}</p>
                            <p class="text-sm text-gray-500">{{ $company->updated_at->diffForHumans() }}</p>
                        </div>

                    </div>
                    
                    <!-- Subscription Management Section -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">Subscription Management</h3>
                        
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Current Status -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Current Status</label>
                                <div>
                                    @if($company->is_blocked)
                                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Blocked
                                        </span>
                                    @elseif($company->isSubscriptionExpired())
                                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg bg-orange-100 text-orange-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Subscription Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Active
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Block/Unblock Toggle -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Account Control</label>
                                <form action="{{ route('admin.company.toggle-block', $company->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-2 rounded-lg font-medium transition-colors {{ $company->is_blocked ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-orange-500 hover:bg-orange-600 text-white' }}">
                                        {{ $company->is_blocked ? 'Unblock Company' : 'Block Company' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Subscription Dates Form -->
                        <form action="{{ route('admin.company.update-subscription', $company->id) }}" method="POST" class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-xl">
                            @csrf
                            <h4 class="font-semibold text-gray-800 mb-4">Update Subscription Dates</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Subscription Start -->
                                <div>
                                    <label for="subscription_start" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="date" id="subscription_start" name="subscription_start" 
                                           value="{{ $company->subscription_start ? $company->subscription_start->format('Y-m-d') : '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                
                                <!-- Subscription End -->
                                <div>
                                    <label for="subscription_end" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="date" id="subscription_end" name="subscription_end" 
                                           value="{{ $company->subscription_end ? $company->subscription_end->format('Y-m-d') : '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <button type="button" onclick="setSubscriptionDates(30)" class="px-3 py-1 text-sm bg-white border border-purple-300 text-purple-700 rounded-md hover:bg-purple-50 transition-colors">
                                    +30 Days
                                </button>
                                <button type="button" onclick="setSubscriptionDates(365)" class="px-3 py-1 text-sm bg-white border border-purple-300 text-purple-700 rounded-md hover:bg-purple-50 transition-colors">
                                    +1 Year
                                </button>
                                <button type="button" onclick="clearSubscriptionDates()" class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                                    Clear Dates
                                </button>
                            </div>
                            
                            <button type="submit" class="mt-4 px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                Update Subscription
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                        Back
                    </a>
                    <form action="{{ route('admin.company.delete', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Company
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script>
        function setSubscriptionDates(days) {
            const startDate = new Date();
            const endDate = new Date();
            endDate.setDate(endDate.getDate() + days);
            
            document.getElementById('subscription_start').value = startDate.toISOString().split('T')[0];
            document.getElementById('subscription_end').value = endDate.toISOString().split('T')[0];
        }
        
        function clearSubscriptionDates() {
            document.getElementById('subscription_start').value = '';
            document.getElementById('subscription_end').value = '';
        }
    </script>

</body>
</html>

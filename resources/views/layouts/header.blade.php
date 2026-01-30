<header class="bg-gradient-to-r from-green-600 to-blue-600 shadow-lg">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white flex items-center gap-2">
                    <span class="text-white">Invoice</span>Desk
                </a>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="text-white/90 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('customers.index') }}" class="text-white/90 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-all {{ request()->routeIs('customers.*') ? 'bg-white/20' : '' }}">
                        Customers
                    </a>
                    <a href="{{ route('products.index') }}" class="text-white/90 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-all {{ request()->routeIs('products.*') ? 'bg-white/20' : '' }}">
                        Products
                    </a>
                    <a href="{{ route('invoices.index') }}" class="text-white/90 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-all {{ request()->routeIs('invoices.*') ? 'bg-white/20' : '' }}">
                        Invoices
                    </a>
                    <a href="{{ route('report') }}" class="text-white/90 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-all {{ request()->routeIs('report') ? 'bg-white/20' : '' }}">
                        Reports
                    </a>
                </nav>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-white font-semibold">{{ auth()->user()->company_name }}</p>
                    <p class="text-white/80 text-sm">{{ auth()->user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

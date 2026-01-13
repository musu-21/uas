<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- WELCOME MESSAGE --}}
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Halo, <span class="text-orange-600">{{ Auth::user()->name }}!</span> 👋</h1>
                <p class="text-gray-600 mt-2">Berikut adalah ringkasan performa toko hari ini.</p>
            </div>

            {{-- STATISTIK CEPAT (HARI INI) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                {{-- Card 1: Omset Hari Ini --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-gray-500 text-xs uppercase font-bold">Omset Hari Ini</p>
                    <h3 class="text-2xl font-extrabold text-gray-800 mt-1">
                        Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                    </h3>
                </div>

                {{-- Card 2: Transaksi Hari Ini --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-gray-500 text-xs uppercase font-bold">Transaksi Hari Ini</p>
                    <h3 class="text-2xl font-extrabold text-gray-800 mt-1">
                        {{ $totalTransactions }} <span class="text-sm font-normal text-gray-400">Nota</span>
                    </h3>
                </div>

                {{-- Card 3: Total Menu --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
                    <p class="text-gray-500 text-xs uppercase font-bold">Total Menu</p>
                    <h3 class="text-2xl font-extrabold text-gray-800 mt-1">
                        {{ $totalProducts }} <span class="text-sm font-normal text-gray-400">Item</span>
                    </h3>
                </div>

                {{-- Card 4: Stok Menipis (Warning) --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                    <p class="text-red-500 text-xs uppercase font-bold">Stok Menipis (< 10)</p>
                    <h3 class="text-2xl font-extrabold text-red-600 mt-1">
                        {{ $lowStockProducts }} <span class="text-sm font-normal text-gray-400">Item</span>
                    </h3>
                </div>
            </div>

            {{-- MENU NAVIGASI CEPAT (YANG LAMA) --}}
            <h3 class="font-bold text-lg text-gray-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('products.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-orange-300 transition group">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-orange-600">Kelola Menu</h5>
                    <p class="font-normal text-gray-700 text-sm">Tambah menu baru, update harga, atau atur stok dimsum.</p>
                </a>

                <a href="{{ route('admin.reports') }}" class="block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-300 transition group">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-blue-600">Laporan Penjualan</h5>
                    <p class="font-normal text-gray-700 text-sm">Pantau grafik penjualan dan total pendapatan toko.</p>
                </a>

                <a href="{{ route('profile.edit') }}" class="block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-green-300 transition group">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-green-600">Akun Saya</h5>
                    <p class="font-normal text-gray-700 text-sm">Kelola profil admin, email, dan keamanan password.</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
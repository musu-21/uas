<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BAGIAN 1: RINGKASAN (KARTU STATISTIK) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Kartu 1: Omset Total --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                        <h3 class="text-2xl font-extrabold text-orange-600">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-full text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Kartu 2: Pendapatan Hari Ini --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-green-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pendapatan Hari Ini</p>
                        <h3 class="text-2xl font-extrabold text-green-600">
                            Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Kartu 3: Total Transaksi --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                        <h3 class="text-2xl font-extrabold text-blue-600">
                            {{ $totalTransactions }} <span class="text-sm font-normal text-gray-400">Nota</span>
                        </h3>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: TABEL RIWAYAT TRANSAKSI --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Transaksi Terbaru</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-orange-50">
                                <tr>
                                    <th class="px-6 py-3 rounded-tl-lg">No Invoice</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Kasir</th>
                                    <th class="px-6 py-3">Total Belanja</th>
                                    <th class="px-6 py-3 text-center rounded-tr-lg">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                <tr class="bg-white border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        #{{ $trx->invoice_code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $trx->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">
                                            {{ $trx->user->name ?? 'Admin' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-green-600">
                                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Tombol Lihat Struk (Re-print) --}}
                                        <a href="{{ route('kasir.print', $trx->id) }}" target="_blank" class="text-orange-600 hover:text-orange-900 font-medium hover:underline">
                                            Lihat Struk
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        Belum ada data transaksi penjualan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
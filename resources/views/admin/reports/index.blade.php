<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Riwayat Transaksi Masuk</h3>

                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Invoice</th>
                            <th class="border border-gray-300 px-4 py-2">Kasir Bertugas</th>
                            <th class="border border-gray-300 px-4 py-2">Total Belanja</th>
                            <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono text-blue-600">
                                    {{ $trx->invoice_code }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $trx->user->name }} {{-- Ini mengambil nama dari relasi User --}}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 font-bold text-green-600">
                                    Rp {{ number_format($trx->total_price) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-sm text-gray-500">
                                    {{ $trx->transaction_date }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
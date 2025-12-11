<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Kasir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Grid Layout: Kiri (Menu), Kanan (Cart) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- KOLOM KIRI: DAFTAR PRODUK --}}
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Pilih Menu</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($products as $product)
                            <div class="border rounded-lg p-4 flex flex-col justify-between items-center text-center">
                                <div>
                                    <h4 class="font-bold">{{ $product->name }}</h4>
                                    <p class="text-gray-600">Rp {{ number_format($product->price) }}</p>
                                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                </div>
                                
                                {{-- Form Tambah ke Keranjang --}}
                                <form action="{{ route('kasir.addToCart', $product->id) }}" method="POST" class="mt-2 w-full">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="border rounded w-16 text-center text-sm mb-2">
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-black-700 text-black text-sm font-bold py-1 px-2 rounded">
                                        + Tambah
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- KOLOM KANAN: KERANJANG BELANJA --}}
                <div class="md:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit">
                    <h3 class="text-lg font-bold mb-4">Keranjang</h3>
                    
                        {{-- Alert Sukses & Tombol Cetak --}}
                        @if(session('success'))
                            <div class="p-4 mb-4 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium">{{ session('success') }}</span>
                                    
                                    {{-- Cek apakah ada ID transaksi untuk dicetak? --}}
                                    @if(session('last_transaction_id'))
                                        <a href="{{ route('kasir.print', session('last_transaction_id')) }}" 
                                           target="_blank"
                                           class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-3 rounded flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            CETAK STRUK
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                    @if(count($cart) > 0)
                        <ul class="mb-4 divide-y divide-gray-200">
                            @foreach($cart as $id => $details)
                                <li class="py-2 flex justify-between">
                                    <div>
                                        <span class="block font-semibold text-sm">{{ $details['name'] }}</span>
                                        <span class="text-xs text-gray-500">{{ $details['quantity'] }} x Rp {{ number_format($details['price']) }}</span>
                                    </div>
                                    <span class="font-semibold text-sm">
                                        Rp {{ number_format($details['price'] * $details['quantity']) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="border-t pt-4 mb-4 flex justify-between font-bold">
                            <span>Total:</span>
                            <span>Rp {{ number_format($total_price) }}</span>
                        </div>

                        {{-- Tombol Checkout --}}
                        <form action="{{ route('kasir.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                                BAYAR SEKARANG
                            </button>
                        </form>
                    @else
                        <p class="text-gray-500 text-sm text-center">Keranjang masih kosong.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
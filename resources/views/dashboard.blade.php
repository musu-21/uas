<x-app-layout>
    {{-- Header ditiadakan agar layar lebih luas untuk POS --}}
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KOLOM KIRI: KATALOG PRODUK (Grid Layout) --}}
                <div class="lg:col-span-2">
                    
                    {{-- Judul Seksi --}}
                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Menu Dimsum</h2>
                        <span class="text-sm text-gray-500">Total Menu: {{ $products->count() }}</span>
                    </div>

                    {{-- Grid Produk --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($products as $product)
                            {{-- Card Component Modern --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                                
                                {{-- Placeholder Gambar (Otomatis generate gambar berdasarkan nama menu) --}}
                                <div class="h-32 bg-gray-200 w-full object-cover relative">
                                    <img src="https://placehold.co/400x300/orange/white?text={{ urlencode($product->name) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                    
                                    {{-- Badge Stok --}}
                                    <span class="absolute top-2 right-2 bg-white/90 text-xs font-bold px-2 py-1 rounded-full {{ $product->stock < 5 ? 'text-red-600' : 'text-green-600' }}">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>

                                {{-- Informasi Produk --}}
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="font-bold text-gray-900 text-lg mb-1 truncate">{{ $product->name }}</h3>
                                    <p class="text-orange-500 font-bold text-md mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    
                                    {{-- Form Add to Cart (Di bagian bawah card) --}}
                                    <form action="{{ route('kasir.addToCart', $product->id) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            {{-- Input Qty Kecil --}}
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                   class="w-12 text-center border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 p-2">
                                            
                                            {{-- Tombol Tambah --}}
                                            <button type="submit" class="flex-1 bg-gray-900 hover:bg-orange-600 text-white font-medium py-2 px-3 rounded-lg transition-colors duration-200 text-sm flex justify-center items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- KOLOM KANAN: KERANJANG (Sticky Sidebar) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 p-6 sticky top-6">
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Order Saat Ini
                        </h3>

                        {{-- Alert Sukses --}}
                        @if(session('success'))
                            <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <div class="ms-3 text-sm font-medium">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                            </div>
                        @endif

                        {{-- Alert Error --}}
                        @if(session('error'))
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- List Item Keranjang --}}
                        <div class="overflow-y-auto max-h-[400px] mb-6 pr-2 custom-scrollbar">
                            @if(count($cart) > 0)
                                <ul class="space-y-4">
                                    @foreach($cart as $id => $details)
                                        <li class="flex justify-between items-start pb-4 border-b border-gray-100 last:border-0">
                                            <div>
                                                <h4 class="font-semibold text-gray-800">{{ $details['name'] }}</h4>
                                                <div class="text-sm text-gray-500 mt-1">
                                                    {{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <span class="font-bold text-gray-900">
                                                Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-10 text-gray-400 flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <p>Keranjang kosong</p>
                                </div>
                            @endif
                        </div>

                        {{-- Total & Checkout --}}
                        <div class="border-t border-gray-200 pt-4 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Tagihan</span>
                                <span class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($total_price, 0, ',', '.') }}</span>
                            </div>

                            <form action="{{ route('kasir.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="w-full text-white bg-gradient-to-r from-orange-500 to-red-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-orange-200 font-medium rounded-lg text-lg px-5 py-3 text-center transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ count($cart) == 0 ? 'disabled' : '' }}>
                                    BAYAR SEKARANG
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
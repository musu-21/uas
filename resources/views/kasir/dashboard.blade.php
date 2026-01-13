<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Kasir - Order Baru') }}
            </h2>
            <div class="text-sm text-gray-500">
                Kasir Bertugas: <span class="font-bold text-orange-600">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUKSES --}}
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                
                @if(session('last_transaction_id'))
                    <a href="{{ route('kasir.print', session('last_transaction_id')) }}" target="_blank" class="underline font-bold ml-2">Cetak Struk</a>
                @endif
            </div>
            @endif

            {{-- ALERT ERROR --}}
            @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">
                
                {{-- BAGIAN KIRI: DAFTAR MENU (TEXT ONLY) --}}
                <div class="w-full lg:w-2/3">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-700">Pilih Menu Dimsum</h3>
                        <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full font-bold">Total Menu: {{ $products->count() }}</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($products as $product)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:border-orange-300 hover:shadow-md transition-all duration-200 flex flex-col justify-between h-full group">
                            
                            <div>
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h4 class="font-bold text-gray-800 text-lg leading-tight group-hover:text-orange-600 transition-colors">
                                        {{ $product->name }}
                                    </h4>
                                    <span class="{{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">
                                        {{ $product->stock }}
                                    </span>
                                </div>
                                <p class="text-gray-500 text-xs uppercase tracking-wide">Harga Satuan</p>
                                <p class="text-orange-600 font-extrabold text-xl mb-4">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mt-auto">
                                <form action="{{ route('transactions.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }} 
                                        class="w-full py-2 px-4 rounded-lg font-bold transition-all duration-200 flex items-center justify-center gap-2 text-sm
                                        {{ $product->stock > 0 
                                            ? 'bg-orange-50 text-orange-700 border border-orange-200 hover:bg-orange-600 hover:text-white hover:shadow-lg' 
                                            : 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                                        }}">
                                        @if($product->stock > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah
                                        @else
                                            Habis
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- BAGIAN KANAN: KERANJANG (DENGAN TOMBOL HAPUS) --}}
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 sticky top-6">
                        <div class="flex items-center gap-3 mb-6 border-b pb-4">
                            <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Pesanan Aktif</h3>
                        </div>

                        @if(empty($cart) || count($cart) == 0)
                            <div class="text-center py-8 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="font-medium">Keranjang masih kosong.</p>
                                <p class="text-xs mt-1">Klik "Tambah" pada menu di samping.</p>
                            </div>
                        @else
                            {{-- LIST ITEM DENGAN TOMBOL HAPUS --}}
                            <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($cart as $id => $details)
                                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100 group hover:border-red-200 transition-colors">
                                    
                                    {{-- Info Item --}}
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $details['name'] }}</h4>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                    
                                    {{-- Harga & Tombol Hapus --}}
                                    <div class="flex items-center gap-3">
                                        <div class="font-bold text-orange-600">
                                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </div>
                                        
                                        {{-- FORM HAPUS ITEM --}}
                                        <form action="{{ route('kasir.remove_item', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-all" title="Hapus Item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="border-t border-dashed border-gray-300 pt-4 mb-6">
                                <div class="flex justify-between items-center text-lg font-bold text-gray-900">
                                    <span>Total Bayar</span>
                                    <span class="text-2xl text-orange-600">Rp {{ number_format($total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <form action="{{ route('kasir.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white py-3.5 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex justify-center items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Bayar Sekarang
                                </button>
                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
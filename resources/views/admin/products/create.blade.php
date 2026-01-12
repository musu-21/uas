<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- KOTAK PUTIH (CARD) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-8">

                {{-- Tombol Kembali --}}
                <div class="mb-8">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-600 font-medium transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Menu
                    </a>
                </div>
                        
                {{-- FORM INPUT --}}
                <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                    @csrf 

                    {{-- Input Nama Menu --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Dimsum</label>
                        <input type="text" name="name" id="name" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition duration-150 ease-in-out" 
                            placeholder="Contoh: Dimsum Udang Premium">
                    </div>

                    {{-- Grid Dua Kolom (Harga & Stok) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Input Harga --}}
                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Harga (Rupiah)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="price" id="price" required
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition duration-150 ease-in-out" 
                                    placeholder="15000">
                            </div>
                        </div>

                        {{-- Input Stok --}}
                        <div>
                            <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">Stok Awal</label>
                            <input type="number" name="stock" id="stock" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition duration-150 ease-in-out" 
                                placeholder="50">
                        </div>
                    </div>

                    {{-- Garis Pemisah --}}
                    <div class="border-t border-gray-100 pt-6 mt-6">
                        <div class="flex items-center gap-4">
                            {{-- Tombol Simpan (Oranye) --}}
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200">
                                Simpan Data
                            </button>

                            {{-- Tombol Batal --}}
                            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-800 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                                Batal
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
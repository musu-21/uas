<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- PENTING: Form mengarah ke route 'products.store' --}}
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf {{-- Token keamanan wajib Laravel --}}

                    {{-- Input Nama --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Dimsum</label>
                        <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: Dimsum Ayam">
                    </div>

                    {{-- Input Harga --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rupiah)</label>
                        <input type="number" name="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 15000">
                    </div>

                    {{-- Input Stok --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stok Awal</label>
                        <input type="number" name="stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 50">
                    </div>

                    {{-- Tombol Simpan & Batal --}}
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Data
                        </button>
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-800">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
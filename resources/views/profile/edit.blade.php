<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Profile Akun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- BAGIAN 1: UPDATE INFO PROFIL --}}
            <div class="p-8 bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Pengguna</h3>
                    <p class="text-sm text-gray-600 mb-6">Update nama akun dan alamat email profile Anda.</p>
                    
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- BAGIAN 2: UPDATE PASSWORD --}}
            <div class="p-8 bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Update Password</h3>
                    <p class="text-sm text-gray-600 mb-6">Pastikan akun Anda aman dengan password yang kuat.</p>

                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- BAGIAN 3: HAPUS AKUN --}}
            <div class="p-8 bg-white shadow-sm sm:rounded-xl border border-red-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-red-600 mb-2">Zona Bahaya</h3>
                    <p class="text-sm text-gray-600 mb-6">Setelah akun dihapus, semua data akan hilang permanen.</p>

                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Dimsum Enak</title>
    
    {{-- Panggil CSS & JS (Tailwind) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <div class="flex min-h-screen">
        
        {{-- BAGIAN KIRI: GAMBAR (Hanya muncul di layar laptop/besar) --}}
        <div class="hidden lg:flex lg:w-1/2 bg-orange-50 justify-center items-center relative overflow-hidden">
            {{-- Gambar Background --}}
            <img src="{{ asset('img/dimsum.jpeg')}}" 
                 alt="Dimsum Background" 
                 class="absolute inset-0 w-full h-full object-cover opacity-90">
            
            <div class="relative z-10 bg-black/40 p-10 text-white text-center rounded-xl backdrop-blur-sm">
                <h1 class="text-4xl font-bold mb-2">Dimsum Lezat</h1>
                <p class="text-lg">Sistem Kasir & Manajemen Stok Terpadu</p>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM REGISTER --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                {{-- Logo / Judul Mobile --}}
                <div class="text-center">
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Daftar
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Silahkan Daftar untuk melanjutkan
                    </p>
                </div>

                {{-- Alert Error (Jika password salah) --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf

                    {{-- Input Nama --}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input type="name" name="name" id="name" required autofocus autocomplete="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" 
                            placeholder="nama kamu" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Input Email --}}
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" required autofocus autocomplete="username"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" 
                            placeholder="nama@dimsum.com" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" 
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- confirm password -->
                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" 
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-centers justify-end mt-4">
                        <a class="underline text-sm text=gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('login')}}">
                            Sudah terdaftar? Login di sini
                        </a>
                    </div>

                    {{-- Tombol Daftar --}}
                    <button type="submit" class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200">
                        Daftar Sekarang
                    </button>

                </form>

                <p class="mt-4 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Project UAS Dimsum.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dimsum Enak - Selamat Datang</title>
    {{-- Panggil CSS Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-orange-50 font-sans text-gray-900 antialiased">
    
    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        
        {{-- Background Hiasan --}}
        <img src="{{ asset('img/dimsum-bg.jpg') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-b from-orange-100/50 to-orange-50"></div>

        {{-- Konten Utama --}}
        <div class="relative z-10 text-center px-6 max-w-2xl">
            
            {{-- Logo Sederhana --}}
            <div class="mx-auto mb-8 bg-white p-4 rounded-full shadow-xl w-24 h-24 flex items-center justify-center border-4 border-orange-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-orange-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 001-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                </svg>
            </div>

            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-4 tracking-tight leading-tight">
                Dimsum <span class="text-orange-600">Lezat</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                Nikmati kelezatan dimsum premium dengan sistem pemesanan yang cepat, praktis, dan terintegrasi.
            </p>

            {{-- Tombol Navigasi --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if (Route::has('login'))
                    @auth
                        {{-- Jika User SUDAH Login --}}
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-3 bg-orange-600 text-white font-bold rounded-full shadow-lg hover:bg-orange-700 hover:shadow-xl transition transform hover:-translate-y-1">
                            Kembali ke Dashboard
                        </a>
                    @else
                        {{-- Jika BELUM Login --}}
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3 bg-gray-900 text-white font-bold rounded-full shadow-lg hover:bg-gray-800 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <span>Login Pegawai</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3 bg-white text-orange-600 border-2 border-orange-100 font-bold rounded-full shadow-sm hover:bg-orange-50 transition transform hover:-translate-y-1">
                            Daftar Akun Baru
                        </a>
                    @endauth
                @endif
            </div>
        </div>

        <div class="absolute bottom-6 text-sm text-gray-400">
            &copy; {{ date('Y') }} Project UAS - Kelompok Kamu
        </div>
    </div>
</body>
</html>
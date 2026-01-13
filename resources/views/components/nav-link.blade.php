@props(['active'])

@php
$classes = ($active ?? false)
            // KONDISI AKTIF (Sedang diklik):
            // - text-gray-900 (Hitam lembut, bukan pekat)
            // - font-bold (Tebal standar, bukan extrabold)
            // - border-orange-500 (Garis bawah oranye)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-orange-500 text-sm font-bold leading-5 text-gray-900 focus:outline-none focus:border-orange-700 transition duration-150 ease-in-out'
            
            // KONDISI TIDAK AKTIF (Menu lain):
            // - text-gray-600 (Abu-abu jelas, tidak pudar tapi tidak nusuk)
            // - font-semibold (Agak tebal, supaya tetap terbaca)
            // - Hover jadi Oranye
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-semibold leading-5 text-gray-600 hover:text-orange-600 hover:border-orange-300 focus:outline-none focus:text-orange-700 focus:border-orange-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
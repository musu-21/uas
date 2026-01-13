@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm w-full text-gray-900 bg-white placeholder-gray-400'
]) !!}>
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-300 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out current-btn'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-red-800 hover:border-gray-300 focus:outline-none focus:text-gray-100 focus:border-gray-300 transition duration-150 ease-in-out current-btn';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 bg-red-600/50 text-white focus:ring-opacity-50']) !!}>

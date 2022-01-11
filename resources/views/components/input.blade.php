@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-gray-700 bg-white bg-opacity-5 block rounded-lg py-3 px-4 text-md w-full text-white text-opacity-70 focus:text-opacity-100']) !!}>

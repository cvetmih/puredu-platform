@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-gray-700 bg-white bg-opacity-5 rounded-lg py-3 px-4 text-md text-white text-opacity-70 focus:text-opacity-100 appearance-none ring-purple-500 focus:ring-2 focus:outline-none hover:border-gray-500 transition-colors']) !!}>

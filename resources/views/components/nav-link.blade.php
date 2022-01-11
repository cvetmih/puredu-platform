@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center font-bold py-1 px-14 border-l-8 border-white focus:outline-none2 transition duration-150 ease-in-out'
            : 'inline-flex items-center font-bold py-1 px-16 text-gray-500 hover:text-gray-300 focus:outline-none2 focus:text-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

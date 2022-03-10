@props(['active'])

@php
    $classes = 'inline-flex items-center font-bold py-1 transition duration-150 ease-in-out ';
    $classes .= $active
                ? 'px-14 border-l-8 border-white'
                : 'px-16 text-gray-500 hover:text-gray-300 focus:text-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

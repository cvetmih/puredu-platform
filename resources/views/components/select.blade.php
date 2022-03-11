@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-gray-700 hover:border-gray-500 bg-white bg-opacity-5 rounded-lg py-3 px-4 text-md text-white text-opacity-70 focus:text-opacity-100 ring-purple-500 focus:ring-2 appearance-none focus:outline-none cursor-pointer hover:border-gray-500 transition-colors']) !!}>
    {{ $slot }}
</select>

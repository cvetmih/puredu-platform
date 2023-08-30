@php
    $element = isset($attributes['href']) ? 'a' : 'button';
    $size = isset($attributes['size']) ? $attributes['size'] : 'small';
    $theme = isset($attributes['theme']) ? $attributes['theme'] : 'primary';

    $themeClasses = [
      'primary' => 'bg-gradient-to-br from-pink-400 to-purple-500 ring-purple-400',
      'secondary' => 'bg-gradient-to-br from-green-400 to-blue-400',
      'ghost' => 'bg-white bg-opacity-10 hover:bg-opacity-20',
      // 'bg-gradient-to-br from-green-400 to-blue-400'
    ];

    $sizeClasses = [
        'big' => 'py-3 px-6 rounded-full',
        'small' => 'py-2 px-6 rounded-lg'
    ];

    $baseClasses = 'font-bold border-0 focus:ring-2 focus:outline-none transition-colors duration-200 inline-flex justify-center items-center';

    $classes = implode(' ', [$baseClasses, $sizeClasses[$size], $themeClasses[$theme]]);
@endphp

<{{ $element }} {{ $attributes->merge(['class' => $classes]) }}>
{{ $slot }}
</{{ $element }}>

@php
    if(!isset($status)) $status = 'success';

    $themeClasses = 'bg-';

    switch($status){
        case 'error':
            $themeClasses = 'bg-red-500 text-white';
            break;
        case 'warning':
        case 'waiting':
            $themeClasses = 'bg-yellow-500 text-white';
        break;
        case 'success':
        case 'paid':
            $themeClasses = 'bg-green-500 text-white';
            break;
        default:
            $themeClasses = 'bg-gray-400 text-black';
            break;
    }

@endphp
<span {{ $attributes->merge(['class' => 'font-bold text-xs uppercase text-center py-1 px-3 rounded-sm ' . $themeClasses]) }}>
    {{ $status }}
</span>

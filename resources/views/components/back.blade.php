<a {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 uppercase text-xs font-bold mb-4 text-white text-opacity-70 hover:text-opacity-100']) }}>
    <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3.83 4L6.41 1.41L5 0L0 5L5 10L6.41 8.59L3.83 6H20V4H3.83Z" fill="currentColor"/>
    </svg>
    {{ $slot }}
</a>

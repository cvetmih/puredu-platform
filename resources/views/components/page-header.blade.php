<header {!! $attributes->merge(['class' => 'flex items-center justify-between mb-4']) !!}>
    <div>
        @if(isset($backlink))
            <x-back href="{{ $backlink }}">{{ $back }}</x-back>
        @endif
        <h1 class="text-3xl font-bold">{{ $title }}</h1>
    </div>
    {{ $slot }}
</header>

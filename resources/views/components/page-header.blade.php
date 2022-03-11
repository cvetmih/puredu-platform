<header {!! $attributes->merge(['class' => 'flex items-center justify-between mb-4']) !!} style="min-height:48px;">
    <div class="flex flex-col gap-2">
        @if(isset($backlink))
            <x-back href="{{ $backlink }}">{{ $back }}</x-back>
        @endif
        <h1 class="text-3xl font-bold">{{ $title }}</h1>
    </div>
    {{ $slot }}
</header>

@php
    $size = isset($attributes['size']) ? $attributes['size'] : 'small';
    $theme = isset($attributes['theme']) ? $attributes['theme'] : 'primary';
    $id = 'button' . \Illuminate\Support\Str::random(12);
    $types = (new \App\Models\Lesson())->types;
    $position = isset($attributes['position']) ? $attributes['position'] : 'right';
@endphp

<div class="relative inline-flex" data-dropdown-container="{{ $id }}">
    <x-button
        :theme="$theme"
        :size="$size"
        :id="$id"
        {{ $attributes->merge(['class' => '']) }}
    >
        {{ $slot }}
    </x-button>
    <div class="absolute top-full {{ $position === 'right' ? 'right-0' : 'left-0' }} mt-4 w-40 bg-black border border-gray-500 rounded-lg overflow-hidden hidden"
         data-dropdown="{{ $id }}">
        @foreach($types as $value => $label)
            <a href="{{ route('lessons.create', $value) }}"
               class="flex items-center gap-2 py-2 px-4 hover:bg-white hover:bg-opacity-20"
            >
                <div class="w-6">
                    <x-icon icon="{{ $value }}"/>
                </div>
                {{ $label }}</a>
        @endforeach
    </div>
</div>

@push('scripts')
    <script>
        const handleClickButton{{$id}} = (e) => {
            e.preventDefault();
            e.target.closest('[data-dropdown-container]').querySelector('[data-dropdown]').classList.toggle('hidden')
        };

        const handleClickOutside{{ $id }} = (e) => {
            const closest = e.target.closest(['[data-dropdown-container]']);
            if (!closest) {
                document.querySelector('[data-dropdown="{{ $id }}"]').classList.add('hidden');
            }
        };

        const {{ $id }} = document.getElementById('{{ $id }}');
        {{ $id }}.addEventListener('click', handleClickButton{{ $id }});
        document.addEventListener('click', handleClickOutside{{ $id }})
    </script>
@endpush

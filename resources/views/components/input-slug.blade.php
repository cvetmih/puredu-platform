@php
    $slug = $attributes['slug'];
    $attributes['type'] = 'text';
@endphp

<x-input data-slug="{{ $slug }}" {{ $attributes->merge(['class' => '']) }}/>

@push('scripts')
    <script>
        const original = document.getElementById('{{ $slug }}');
        console.log(original);
        const slugInput = document.querySelector('[data-slug="{{ $slug }}"]');

        const handleChangeOriginal{{ $slug }} = (e) => {
            slugInput.value = e.target.value.slugify();
        };

        if (original) {
            original.addEventListener('change', handleChangeOriginal{{ $slug }})
            original.addEventListener('keyup', handleChangeOriginal{{ $slug }})
        }
    </script>
@endpush

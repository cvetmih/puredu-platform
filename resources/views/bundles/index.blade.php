<x-app-layout>
    <x-container>
        <x-page-header title="Bundles">
            <x-button href="{{ route('bundles.create') }}" size="big">Create a new bundle</x-button>
        </x-page-header>

        <x-box class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            @foreach($bundles as $key => $bundle)
                @php
                    $colors = [
                        'from-green-400 to-blue-400',
                        'from-red-500 to-red-400',
                        'from-pink-400 to-purple-600',
                        'from-yellow-400 to-yellow-400',
                    ];
                @endphp
                <a href="{{ route('bundles.show', $bundle) }}"
                   class="flex gap-10 flex-col justify-between min-h-64 bg-gradient-to-br {{ $colors[$key % count($colors)] }} p-6 rounded-xl transform hover:-translate-y-1.5 transition-transform">
                    {{--                                    <div>{{ $bundle->excerpt }}</div>--}}
                    {{--                                    <div>{{ $bundle->users->count() }}</div>--}}
                    {{--                                    <div>{{ $bundle->created_at }}</div>--}}
                    <img src="{{ $bundle->image_url }}" alt="" class="rounded-md w-full">

                    <div class="text-md font-bold">{{ $bundle->title }}</div>
                </a>
            @endforeach

        </x-box>
    </x-container>
</x-app-layout>

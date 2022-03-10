<x-app-layout>
    <x-container>
        <x-page-header title="Courses">
            <x-button href="{{ route('courses.create') }}" size="big">Create a new course</x-button>
        </x-page-header>

        <x-box class="grid grid-cols-5 gap-4">
            @foreach($courses as $key => $course)
                @php
                    $colors = [
                        'from-green-400 to-blue-400',
                        'from-red-500 to-red-400',
                        'from-pink-400 to-purple-600',
                        'from-yellow-400 to-yellow-400',
                    ];
                @endphp
                <a href="{{ route('courses.show', $course) }}"
                   class="flex gap-10 flex-col justify-between bg-gradient-to-br {{ $colors[$key % count($colors)] }} p-6 rounded-xl transform hover:-translate-y-1.5 transition-transform">
{{--                                    <div>{{ $course->excerpt }}</div>--}}
{{--                                    <div>{{ $course->users->count() }}</div>--}}
{{--                                    <div>{{ $course->created_at }}</div>--}}
                    <img src="{{ $course->image_url }}" alt="" class="rounded-md w-full">

                    <div class="text-md font-bold">{{ $course->title }}</div>
                </a>
            @endforeach

        </x-box>
    </x-container>
</x-app-layout>

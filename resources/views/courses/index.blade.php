<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courses
        </h2>
    </x-slot>

    <x-container>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold mb-4">Courses</h1>
            <a href="{{ route('courses.create') }}"
               class="inline-flex bg-gradient-to-br from-primary to-secondary py-3 px-6 rounded-full font-bold">Create new</a>
        </div>

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
                   class="flex flex-col justify-between bg-gradient-to-br {{ $colors[$key % count($colors)] }} p-6 rounded-xl transform hover:-translate-y-1.5 transition-transform">
                    {{--                <div>{{ $course->excerpt }}</div>--}}
                    {{--                <div>{{ $course->users->count() }}</div>--}}
                    {{--                <div>{{ $course->created_at }}</div>--}}
                    <button class="cursor-pointer self-end mb-4">
                        <svg width="18" height="4" viewBox="0 0 18 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M2 4C3.10457 4 4 3.10457 4 2C4 0.89543 3.10457 0 2 0C0.89543 0 0 0.89543 0 2C0 3.10457 0.89543 4 2 4Z"
                                  fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M9 4C10.1046 4 11 3.10457 11 2C11 0.89543 10.1046 0 9 0C7.89543 0 7 0.89543 7 2C7 3.10457 7.89543 4 9 4Z"
                                  fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M16 4C17.1046 4 18 3.10457 18 2C18 0.89543 17.1046 0 16 0C14.8954 0 14 0.89543 14 2C14 3.10457 14.8954 4 16 4Z"
                                  fill="white"/>
                        </svg>
                    </button>
                    <img src="{{ $course->image_id }}" alt="" class="w-24 h-24 rounded-full block mx-auto mb-20 flex-1">

                    <div class="text-md font-bold">{{ $course->title }}</div>
                </a>
            @endforeach

        </x-box>
    </x-container>
</x-app-layout>

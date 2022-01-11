<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lessons
        </h2>
    </x-slot>

    <x-container>
        <div class="grid grid-cols-4 font-bold">
            <div>Title</div>
            <div>Type</div>
            <div>Course</div>
            <div>Created at</div>
        </div>
        @foreach($lessons as $lesson)
            <a href="{{ route('lessons.show', $lesson) }}" class="grid grid-cols-4">
                <div>{{ $lesson->title }}</div>
                <div>{{ $lesson->type }}</div>
                <div>{{ $lesson->course->title }}</div>
                <div>{{ $lesson->created_at }}</div>
            </a>
        @endforeach

        <div class="mt-4">
            <a href="{{ route('lessons.create') }}" class="bg-gray-200 py-2 px-4 border-2 border-gray-300">Create
                new</a>
        </div>
    </x-container>
</x-app-layout>

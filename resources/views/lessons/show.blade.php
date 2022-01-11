<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lesson {{ $lesson->title }}
        </h2>
    </x-slot>

    <x-container>
        <b>Title:</b> {{ $lesson->title }}<br>
        <b>Slug:</b> {{ $lesson->slug }}<br>
        <b>Description:</b> {{ $lesson->description }}<br>
        <b>Type:</b> {{ $lesson->type }}<br>
        <b>Image_id:</b> {{ $lesson->image_id }}<br>
        <b>Video_id:</b> {{ $lesson->video_id }}<br>
        <b>Course_id:</b> {{ $lesson->course_id }}<br>

        <a href="{{ route('lessons.edit', $lesson) }}" class="underline hover:no-underline">Edit</a>
    </x-container>
</x-app-layout>

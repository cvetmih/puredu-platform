<x-app-layout>
    <x-container>
        <x-page-header title="Lesson {{ $lesson->title }}"
                       back="Back to lessons"
                       backlink="{{ route('lessons.index') }}"
        >
            <x-button href="{{ route('lessons.edit', $lesson) }}" size="big">Edit lesson</x-button>
        </x-page-header>

        <x-box>
            <b>Title:</b> {{ $lesson->title }}<br>
            <b>Slug:</b> {{ $lesson->slug }}<br>
            <b>Description:</b> {{ $lesson->description }}<br>
            <b>Type:</b> {{ $lesson->type }}<br>
            <b>Image_id:</b> {{ $lesson->image_id }}<br>
{{--            @if($lesson->type === 'video')--}}
{{--                <b>Video:</b> {{ $lesson->video->title }}<br>--}}
{{--            @endif--}}
{{--            <b>Course:</b> {{ $lesson->course->title }}<br>--}}
{{--            <b>Chapter:</b> {{ $lesson->chapter->title }}<br>--}}
        </x-box>
    </x-container>
</x-app-layout>

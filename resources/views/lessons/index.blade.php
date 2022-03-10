<x-app-layout>
    <x-container>
        <x-page-header title="Lessons">
            <x-button href="{{ route('lessons.create') }}" size="big">Create a new lesson</x-button>
        </x-page-header>

        <div class="flex flex-col gap-8">
            @foreach($chapters as $chapter)
                <x-box-with-header header="{{ $chapter->title }}">
                    @foreach($chapter->lessons as $lesson)
                        <a href="{{ route('lessons.show', $lesson) }}"
                           class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4 flex items-center justify-between">
                            <div>{{ $lesson->title }}</div>
                            <div>{{ $lesson->type }}</div>
                            {{--                            <div>{{ $lesson->course->title }}</div>--}}
                            <div>{{ $lesson->created_at }}</div>
                        </a>
                    @endforeach
                </x-box-with-header>
            @endforeach
        </div>
    </x-container>
</x-app-layout>

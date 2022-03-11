<x-app-layout>
    <x-container>
        <x-page-header title="Lessons">
            <x-button-lesson>Create a new lesson</x-button-lesson>
        </x-page-header>

        <div class="flex flex-col gap-8">
            @foreach($chapters as $chapter)
                <x-box-with-header header="{{ $chapter->title }}">
                    @foreach($chapter->lessons as $lesson)
                        <a href="{{ route('lessons.show', $lesson) }}"
                           class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4 flex items-center justify-between gap-4">
                            <div class="flex-1">{{ $lesson->title }}</div>
                            <div class="w-6"><x-icon icon="{{ $lesson->type }}"/></div>
                        </a>
                    @endforeach
                </x-box-with-header>
            @endforeach
        </div>
    </x-container>
</x-app-layout>

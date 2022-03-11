<x-app-layout>
    <x-container>
        <x-page-header title="Videos">
            <x-button size="big" href="{{ route('videos.create') }}">Add new video</x-button>
        </x-page-header>

        <x-box class="flex flex-col gap-8">
            @foreach($videos as $video)
                <x-box-with-header header="{{ $video->title }}">

                    {{-- todo: add image --}}
                    <div class="flex items-start px-6 py-4 gap-8">
                        <div class="w-52">
                            thumb
                        </div>
                        <div class="flex-1 flex flex-col gap-2">
                            <div>
                                Used in lessons:
                                @foreach($video->lessons as $key => $lesson)
                                    <a href="{{ route('lessons.show', $lesson) }}"
                                       class="text-primary underline hover:no-underline">{{ $lesson->title }}</a>@if($key !== $video->lessons->count() - 1)
                                        ,@endif
                                @endforeach
                            </div>
                            <div>
                                Times played: todo
                            </div>
                        </div>
                    </div>

                    {{--                @foreach($chapter->lessons as $lesson)--}}
                    {{--                    <a href="{{ route('lessons.show', $lesson) }}" class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4 flex items-center justify-between">--}}
                    {{--                        <div>{{ $lesson->title }}</div>--}}
                    {{--                        <div>{{ $lesson->type }}</div>--}}
                    {{--                        --}}{{--                            <div>{{ $lesson->course->title }}</div>--}}
                    {{--                        <div>{{ $lesson->created_at }}</div>--}}
                    {{--                    </a>--}}
                    {{--                @endforeach--}}
                </x-box-with-header>
            @endforeach
        </x-box>
    </x-container>
</x-app-layout>

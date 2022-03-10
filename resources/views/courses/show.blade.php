<x-app-layout>
    <x-container>
        <x-page-header title="Course {{ $course->title }}"
                       backlink="{{ route('courses.index') }}"
                       back="Back to courses"
        >
            <x-button href="{{ route('courses.edit', $course) }}" size="big">Edit course</x-button>
        </x-page-header>

        <div class="flex gap-4 items-start">
            <x-box-with-header header="Lessons" class="flex-1 flex flex-col">
                <div class="flex items-center justify-between p-4">
                    <x-button href="{{ route('lessons.create') . '?course=' . $course->id }}">
                        Add new
                    </x-button>
                    <x-button href="#" theme="secondary">Reorder</x-button>
                </div>
                <div>
                    @foreach($course->lessons as $key => $lesson)
                        <a href="{{ route('lessons.show', $lesson) }}"
                           class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4 flex items-center justify-between">
                            <div>{{ $key + 1 }}</div>
                            <div class="">{{ $lesson->title }}</div>
                            <div class="">{{ $lesson->type }}</div>
                        </a>
                    @endforeach
                </div>
            </x-box-with-header>
            <x-box class="flex flex-col gap-6 w-1/3">
                <img src="{{ $course->image_url }}" alt="" class="block max-w-full">

                @php
                    $input_class = 'border border-gray-700 bg-white bg-opacity-5 rounded-lg py-3 px-4 text-md text-white text-opacity-70 focus:text-opacity-100'
                @endphp
                @foreach($inputs as $input_name => $input)
                    <div class="">
                        <label for="{{ $input_name }}"
                               class="block text-sm text-white text-opacity-70 mb-1 ">{{ $input['label'] }}</label>

                        @if($input['type'] === 'text')
                            <input type="text"
                                   id="{{ $input_name }}"
                                   name="{{ $input_name }}"
                                   autocomplete="off"
                                   value="{{ $course->{$input_name} }}"
                                   class="{{ $input_class }} block w-full">
                        @elseif($input['type'] === 'textarea')
                            <textarea id="{{ $input_name }}"
                                      name="{{ $input_name }}"
                                      autocomplete="off"
                                      class="{{ $input_class }} block w-full h-32">{{ $course->{$input_name} }}</textarea>
                        @elseif($input['type'] === 'checkbox')
                            <input type="checkbox"
                                   id="{{ $input_name }}"
                                   name="{{ $input_name }}"
                                   value="{{ $course->{$input_name} }}"
                                   class="{{ $input_class }} checked:bg-blue-600" checked>
                        @endif
                    </div>
                @endforeach
            </x-box>
        </div>
    </x-container>
</x-app-layout>

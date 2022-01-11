<x-app-layout>
    <x-container>
        <x-back href="{{ route('courses.index') }}">Back to courses</x-back>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold">Course {{ $course->title }}</h1>

            <a href="{{ route('courses.edit', $course) }}"
               class="inline-flex bg-gradient-to-br from-green-400 to-blue-400 py-3 px-6 rounded-full font-bold">Edit</a>
        </div>

        <div class="flex gap-4 items-start">
            <x-box-with-header header="Lessons" class="flex-1 flex flex-col">
                <a href="{{ route('lessons.create') . '?course=' . $course->id }}">Add new</a>
                <a href="#">Reorder</a>
                @foreach($course->lessons as $key => $lesson)
                    <a href="{{ route('lessons.show', $lesson) }}"
                       class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4 flex items-center justify-between">
                        <div>{{ $key + 1 }}</div>
                        <div class="">{{ $lesson->title }}</div>
                        <div class="">{{ $lesson->type }}</div>
                    </a>
                @endforeach

            </x-box-with-header>
            <x-box class="flex flex-col gap-6 w-1/3">
                <img src="{{ $course->image_url }}" alt="" class="block max-w-full">

                @php($input_class = 'border border-gray-700 bg-white bg-opacity-5 block rounded-lg py-3 px-4 text-md w-full text-white text-opacity-70 focus:text-opacity-100')
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
                                   class="{{ $input_class }}">
                        @elseif($input['type'] === 'textarea')
                            <textarea id="{{ $input_name }}"
                                      name="{{ $input_name }}"
                                      autocomplete="off"
                                      class="{{ $input_class }} h-32">{{ $course->{$input_name} }}</textarea>
                        @elseif($input['type'] === 'checkbox')
                            <input type="checkbox"
                                   id="{{ $input_name }}"
                                   name="{{ $input_name }}"
                                   value="{{ $course->{$input_name} }}"
                                   class="{{ $input_class }} w-auto checked:bg-blue-600" checked>
                        @endif
                    </div>
                @endforeach
            </x-box>
        </div>
    </x-container>
</x-app-layout>

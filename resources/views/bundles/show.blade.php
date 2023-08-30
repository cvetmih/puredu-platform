<x-app-layout>
    <x-container>
        <x-page-header title="Bundle {{ $bundle->title }}"
                       backlink="{{ route('bundles.index') }}"
                       back="Back to bundles"
        >
            <x-button href="{{ route('bundles.edit', $bundle) }}" size="big">Edit bundle</x-button>
        </x-page-header>

        <div class="flex gap-4 items-start">
            <x-box-with-header header="Courses" class="flex-1 flex flex-col">
                <div class="flex items-center justify-between p-4">
                    <x-button-lesson position="left">
                        Add new
                    </x-button-lesson>
                    {{--                    <x-button href="#" theme="secondary">Reorder</x-button>--}}
                </div>
                <div class="flex flex-col gap-4 p-4">
                    @foreach($bundle->courses as $courseKey => $course)
                        <a href="{{ route('courses.show', $course) }}"
                           class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4 flex items-center justify-between gap-4">
                            <div>{{ $courseKey + 1 }}</div>
                            <div class="flex-1">{{ $course->title }}</div>
                            {{--                                    @if($lesson->is_free)--}}
                            {{--                                        <x-tag status="free"/>--}}
                            {{--                                    @endif--}}
                            {{--                                    <div class="w-5">--}}
                            {{--                                        <x-icon icon="{{ $lesson->type }}"/>--}}
                            {{--                                    </div>--}}
                        </a>
                    @endforeach
                </div>
            </x-box-with-header>
            <x-box-with-header header="Quick edit" class="w-1/3">
                <div class="flex flex-col gap-6 p-4">
                    <img src="{{ $bundle->image_url }}" alt="" class="block w-full rounded-lg">

                    @php
                        $input_class = 'border border-gray-700 bg-white bg-opacity-5 rounded-lg py-3 px-4 text-md text-white text-opacity-70 focus:text-opacity-100'
                    @endphp
                    @foreach($inputs as $input_name => $input)
                        <div class="">
                            <label for="{{ $input_name }}"
                                   class="block text-sm text-white text-opacity-70 mb-1 ">{{ $input['label'] }}</label>

                            @if($input['type'] === 'text')
                                <x-input type="text"
                                         id="{{ $input_name }}"
                                         name="{{ $input_name }}"
                                         autocomplete="off"
                                         value="{{ $bundle->{$input_name} }}"
                                         class="{{ $input_class }} block w-full"/>
                            @elseif($input['type'] === 'textarea')
                                <x-textarea id="{{ $input_name }}"
                                            name="{{ $input_name }}"
                                            autocomplete="off"
                                            class="{{ $input_class }} block w-full h-32">{{ $bundle->{$input_name} }}</x-textarea>
                            @elseif($input['type'] === 'checkbox')
                                <x-input type="checkbox"
                                         id="{{ $input_name }}"
                                         name="{{ $input_name }}"
                                         value="{{ $bundle->{$input_name} }}"
                                         class="{{ $input_class }} checked:bg-blue-600" checked/>
                            @endif
                        </div>
                    @endforeach
                </div>
            </x-box-with-header>
        </div>
    </x-container>
</x-app-layout>

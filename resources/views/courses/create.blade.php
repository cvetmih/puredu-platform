<x-app-layout>

    <x-container>
        <x-page-header
            back="Back to courses"
            backlink="{{ route('courses.index') }}"
            title="Create a new course"
        />

        <x-box class="max-w-3xl mx2-auto ">
            <form action="{{ route('courses.store') }}"
                  class="flex flex-col gap-4"
                  method="post"
            >
                {{ csrf_field() }}

                <nav class="flex gap-4 border-b border-gray-800">
                    <button type="button"
                            class="py-2 px-6 font-bold bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg">
                        Settings
                    </button>
                    <button type="button"
                            class="py-2 px-6 font-bold bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg">Lessons
                    </button>
                    <button type="button"
                            class="py-2 px-6 font-bold bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg">Pricing
                    </button>
                    <button type="button"
                            class="py-2 px-6 font-bold bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg">Publish
                    </button>
                </nav>

                @php
                    $input_class = 'border border-gray-700 bg-white bg-opacity-5 block rounded-lg py-3 px-4 text-md w-full text-white text-opacity-70 focus:text-opacity-100';
                @endphp

                @foreach($inputs as $name => $attr)
                    <div>
                        @if($attr['type'] === 'text' || $attr['type'] === 'password')
                            <label class="block text-sm text-white text-opacity-70 mb-1" for="{{ $name }}">
                                {{ $attr['label'] }}
                            </label>
                            <x-input
                                class=" @error($name) border-pink-600 @enderror"
                                id="{{ $name }}" name="{{ $name }}" type="{{ $attr['type'] }}" placeholder=""
                                value="{{ old($name) }}"/>
                        @elseif($attr['type'] === 'textarea')
                            <label class="block text-sm text-white text-opacity-70 mb-1" for="{{ $name }}">
                                {{ $attr['label'] }}
                            </label>
                            <textarea id="{{ $name }}"
                                      name="{{ $name }}"
                                      autocomplete="off"
                                      class="{{ $input_class }} h-32 @error($name) border-pink-600 @enderror">{{ old($name) }}</textarea>
                        @elseif($attr['type'] === 'checkbox')
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="{{ $name }}">
                                <input type="checkbox" id="{{ $name }}" name="{{ $name }}">
                                {{ $attr['label'] }}
                            </label>
                        @endif
                    </div>
                @endforeach


                <div class="flex items-center justify-between">
                    <a class="inline-flex font-bold text-sm text-blue-500 hover:text-blue-800"
                       href="{{ route('courses.index') }}">
                        Go back
                    </a>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Create
                    </button>
                </div>
            </form>
        </x-box>
    </x-container>
</x-app-layout>

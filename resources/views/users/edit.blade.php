<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ $user->name }}
        </h2>
    </x-slot>

    <x-container>

        <form action="{{ route('users.update', $user) }}"
              class="bg-white p-8 max-w-3xl m-auto flex flex-col gap-4"
              method="post"
        >
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            @if($errors->any())
                <div role="alert">
                    <div class="border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @foreach($inputs as $name => $attr)
                <div>
                    @if($attr['type'] === 'text' || $attr['type'] === 'password')
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="{{ $name }}">
                            {{ $attr['label'] }}
                        </label>
                        <input
                            class="shadow appearance-none border @error($name) border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="{{ $name }}" name="{{ $name }}" type="{{ $attr['type'] }}" placeholder=""
                            value="{{ old($name, $attr['type'] !== 'password' ? $user->{$name} : '') }}">
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
                   href="{{ route('users.show', $user) }}">
                    Go back
                </a>
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Update
                </button>
            </div>
        </form>
    </x-container>
</x-app-layout>

<x-box>
    <form {{ $attributes->merge(['class' => 'flex flex-col gap-8']) }}>
        {{ csrf_field() }}

        @if($errors->any())
            <div role="alert">
                <div class="border border-red-400 bg-red-100 px-4 py-3 text-red-700 rounded-lg">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-4">
            @foreach($inputs as $name => $attr)
                <div class="flex flex-col gap-2">
                    @if($attr['type'] !== 'checkbox')
                        <label class="block text-sm text-white text-opacity-70" for="{{ $name }}">
                            {{ $attr['label'] }}
                        </label>
                    @endif

                    @if($attr['type'] === 'text' || $attr['type'] === 'password')
                        <x-input
                            class="{{ $errors->has($name) ? 'border-red-500' : '' }}"
                            id="{{ $name }}"
                            name="{{ $name }}"
                            type="{{ $attr['type'] }}"
                            placeholder=""
                            value="{{ old($name, $attr['type'] !== 'password' ? isset($data->{$name}) ? $data->{$name} : '' : '') }}"
                        />
                    @elseif($attr['type'] === 'checkbox')
                        <label class="block text-sm text-white text-opacity-70" for="{{ $name }}">
                            <x-input type="checkbox"
                                     id="{{ $name }}"
                                     name="{{ $name }}"
                                     class="{{ $errors->has($name) ? 'border-red-500' : '' }}"
                            />
                            {{ $attr['label'] }}
                        </label>
                    @elseif($attr['type'] === 'textarea')
                        <x-textarea name="{{ $name }}"
                                    id="{{ $name }}"
                                    class="{{ $errors->has($name) ? 'border-red-500' : '' }} h-48"
                        >{{ old($name, isset($data->{$name}) ? $data->{$name} : '') }}</x-textarea>
                    @elseif($attr['type'] === 'select')
                        <x-select name="{{ $name }}" id="{{ $name }}">
                            @foreach($attr['options'] as $value => $label)
                                <option value="{{ $value }}"
                                        @if(isset($data->{$name}) && $data->{$name} === $value)
                                        selected
                                    @endif
                                >{{ $label }}</option>
                            @endforeach
                        </x-select>
                    @endif
                </div>
            @endforeach
        </div>

        {{ $slot }}

        <div class="flex justify-end">
            <x-button type="submit">
                {{ $submit }}
            </x-button>
        </div>
    </form>
</x-box>

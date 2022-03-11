<x-box>
    <form {{ $attributes->merge(['class' => 'flex flex-col gap-8']) }}>
        {{ csrf_field() }}

        <div class="flex flex-col gap-4">
            @foreach($inputs as $name => $attr)
                <div class="flex flex-col gap-2">
                    @if($attr['type'] !== 'checkbox' && !$attr['hidden'])
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
                            :hidden="$attr['hidden']"
                            placeholder=""
                            value="{{ old($name, $attr['type'] !== 'password' ? isset($data->{$name}) ? $data->{$name} : '' : '') }}"
                        />
                    @elseif($attr['type'] === 'slug')
                        <x-input-slug
                            class="{{ $errors->has($name) ? 'border-red-500' : '' }}"
                            slug="{{ $attr['slug'] }}"
                            id="{{ $name }}"
                            name="{{ $name }}"
                            type="{{ $attr['type'] }}"
                            :hidden="$attr['hidden']"
                            placeholder=""
                            value="{{ old($name, isset($data->{$name}) ? $data->{$name} : '') }}"
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
                        <x-select name="{{ $name }}" id="{{ $name }}" :hidden="$attr['hidden']">
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

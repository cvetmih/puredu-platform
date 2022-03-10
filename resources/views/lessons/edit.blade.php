<x-app-layout>
    <x-container>
        <x-page-header title="Edit: {{ $lesson->title }}"
                       backlink="{{ route('lessons.show', $lesson) }}"
                       back="Back to {{ $lesson->title }}"
        />

        <x-form action="{{ route('lessons.update', $lesson) }}"
                method="post"
                :inputs="$inputs"
                :data="$lesson"
                submit="Save lesson"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

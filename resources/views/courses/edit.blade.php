<x-app-layout>
    <x-container>
        <x-page-header title="Edit: {{ $course->title }}"
                       back="Back to {{ $course->title }}"
                       backlink="{{ route('courses.show', $course) }}"
        />

        <x-form action="{{ route('courses.update', $course) }}"
                method="post"
                :inputs="$inputs"
                :data="$course"
                submit="Save course"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

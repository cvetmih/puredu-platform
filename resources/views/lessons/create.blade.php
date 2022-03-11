<x-app-layout>
    <x-container>
        <x-page-header title="Create a new lesson"
                       backlink="{{ isset($_GET['course']) ? route('courses.show', $_GET['course']) : route('lessons.index') }}"
                       back="{{ isset($_GET['course']) ? 'Back to course' : 'Back to lessons' }}"
        />

        <x-form action="{{ route('lessons.store') }}"
                method="post"
                :inputs="$inputs"
                :data="['course_id' => isset($_GET['course']) ? $_GET['course'] : '', 'type' => $type]"
                submit="Create lesson"
        />
    </x-container>
</x-app-layout>

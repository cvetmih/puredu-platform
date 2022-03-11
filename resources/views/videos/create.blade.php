<x-app-layout>
    <x-container>
        <x-page-header title="Add a new video"
                       backlink="{{ route('videos.index') }}"
                       back="Back to videos"
        />


        <x-form action="{{ route('videos.store') }}"
                method="post"
                :inputs="$inputs"
                submit="Add video"
        />
    </x-container>
</x-app-layout>

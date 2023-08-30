<x-app-layout>
    <x-container>
        <x-page-header title="Edit: {{ $bundle->title }}"
                       back="Back to {{ $bundle->title }}"
                       backlink="{{ route('bundles.show', $bundle) }}"
        />

        <x-form action="{{ route('bundles.update', $bundle) }}"
                method="post"
                :inputs="$inputs"
                :data="$bundle"
                submit="Save bundle"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

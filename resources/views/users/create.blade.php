<x-app-layout>
    <x-container>
        <x-page-header title="Create a new user"
                       backlink="{{ route('users.index') }}"
                       back="Back to users"
        />

        <x-form action="{{ route('users.store') }}"
                method="post"
                :inputs="$inputs"
        />
    </x-container>
</x-app-layout>

<x-app-layout>
    <x-container>
        <x-page-header title="Edit: {{ $user->name }}"
                       backlink="{{ route('users.show', $user) }}"
                       back="Back to {{ $user->name }}"
        />

        <x-form action="{{ route('users.update', $user) }}"
                method="post"
                :inputs="$inputs"
                :data="$user"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

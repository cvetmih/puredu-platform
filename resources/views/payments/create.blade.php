<x-app-layout>
    <x-container>
        <x-page-header title="Create a new payment"
                       backlink="{{ route('payments.index') }}"
                       back="Back to payments"
        />

        <x-form action="{{ route('payments.store') }}"
                method="post"
                :inputs="$inputs"
                submit="Create payment"
        />
    </x-container>
</x-app-layout>

<x-app-layout>
    <x-container>
        <x-page-header title="Create a new order"
                       backlink="{{ route('orders.index') }}"
                       back="Back to orders"
        />


        <x-form action="{{ route('orders.store') }}"
                method="post"
                :inputs="$inputs"
                submit="Create order"
        />
    </x-container>
</x-app-layout>

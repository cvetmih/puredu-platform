<x-app-layout>
    <x-container>
        <x-page-header title="Edit: Order #{{ $order->id }}"
                       backlink="{{ route('orders.show', $order) }}"
                       back="Back to Order #{{ $order->id }}"
        />

        <x-form action="{{ route('orders.update', $order) }}"
                method="post"
                :inputs="$inputs"
                :data="$order"
                submit="Save order"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

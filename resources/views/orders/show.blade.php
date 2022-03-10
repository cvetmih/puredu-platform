<x-app-layout>
    <x-container>
        <x-page-header title="Order #{{ $order->id }}"
                       backlink="{{ route('orders.index') }}"
                       back="Back to orders"
        >
            <x-button href="{{ route('orders.edit', $order) }}" size="big">Edit order</x-button>
        </x-page-header>

        <x-box>
            <b>User:</b> {{ $order->user->name }}<br>
            <b>Course:</b> {{ $order->course->title }}<br>
            <b>Price:</b> {{ $order->price }}<br>
            <b>Status:</b> {{ $order->status }}<br>
            <b>Method:</b> {{ $order->method }}<br>
            <b>Referrer:</b> {{ $order->referrer }}<br>
            <b>Created At:</b> {{ $order->created_at }}<br>
        </x-box>
    </x-container>
</x-app-layout>

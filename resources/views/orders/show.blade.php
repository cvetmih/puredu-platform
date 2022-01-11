<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->id }}
        </h2>
    </x-slot>

    <x-container>
        <b>User:</b> {{ $order->user->name }}<br>
        <b>Course:</b> {{ $order->course->title }}<br>
        <b>Price:</b> {{ $order->price }}<br>
        <b>Status:</b> {{ $order->status }}<br>
        <b>Method:</b> {{ $order->method }}<br>
        <b>Referrer:</b> {{ $order->referrer }}<br>
        <b>Created At:</b> {{ $order->created_at }}<br>

        <a href="{{ route('orders.edit', $order) }}" class="underline hover:no-underline">Edit</a>
    </x-container>
</x-app-layout>

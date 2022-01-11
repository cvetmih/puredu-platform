<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment {{ $payment->title }}
        </h2>
    </x-slot>

    <x-container>
        <b>Order:</b> #{{ $payment->order->id }}<br>
        <b>User:</b> {{ $payment->user->name }}<br>
        <b>Status:</b> {{ $payment->status }}<br>
        <b>Method:</b> {{ $payment->method }}<br>
        <b>Created at:</b> {{ $payment->created_at }}<br>

        <a href="{{ route('payments.edit', $payment) }}" class="underline hover:no-underline">Edit</a>
    </x-container>
</x-app-layout>

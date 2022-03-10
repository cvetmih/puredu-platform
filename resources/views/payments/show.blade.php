<x-app-layout>
    <x-container>
        <x-page-header title="Payment #{{ $payment->id }}"
                       backlink="{{ route('payments.index') }}"
                       back="Back to payments"
        >
            <x-button href="{{ route('payments.edit', $payment) }}" size="big">Edit payment</x-button>
        </x-page-header>

        <x-box>
            <b>Order:</b> #{{ $payment->order->id }}<br>
            <b>User:</b> {{ $payment->user->name }}<br>
            <b>Status:</b> {{ $payment->status }}<br>
            <b>Method:</b> {{ $payment->method }}<br>
            <b>Created at:</b> {{ $payment->created_at }}<br>
        </x-box>
    </x-container>
</x-app-layout>

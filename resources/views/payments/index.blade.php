<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payments
        </h2>
    </x-slot>

    <x-container>
        <div class="grid grid-cols-4 font-bold">
            <div>Order</div>
            <div>User</div>
            <div>Status</div>
            <div>Created at</div>
        </div>
        @foreach($payments as $payment)
            <a href="{{ route('payments.show', $payment) }}" class="grid grid-cols-4">
                <div>{{ $payment->order->id }}</div>
                <div>{{ $payment->user->name }}</div>
                <div>{{ $payment->status }}</div>
                <div>{{ $payment->created_at }}</div>
                {{--                @dd($payment)--}}
            </a>
        @endforeach

        <div class="mt-4">
            <a href="{{ route('payments.create') }}" class="bg-gray-200 py-2 px-4 border-2 border-gray-300">Create new</a>
        </div>
    </x-container>
</x-app-layout>

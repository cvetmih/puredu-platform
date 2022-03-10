<x-app-layout>
    <x-container>
        <x-page-header title="Payments">
            <x-button href="{{ route('payments.create') }}" size="big">Create a new payment</x-button>
        </x-page-header>

        <x-box>
            <div class="px-6 pb-4 grid grid-cols-4 font-bold border-b-2 border-gray-600">
            <div>Order</div>
                <div>User</div>
                <div>Status</div>
                <div>Created at</div>
            </div>
            @foreach($payments as $key => $payment)
                <a href="{{ route('payments.show', $payment) }}"
                   class="px-6 py-4 grid grid-cols-4 bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== count($payments)) border-b border-gray-800 @endif"
                >
                    <div>{{ $payment->order->id }}</div>
                    <div>{{ $payment->user->name }}</div>
                    <div>{{ $payment->status }}</div>
                    <div>{{ $payment->created_at }}</div>
                    {{--                @dd($payment)--}}
                </a>
            @endforeach

        </x-box>
    </x-container>
</x-app-layout>

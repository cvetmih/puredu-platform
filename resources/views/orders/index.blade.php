<x-app-layout>
    <x-container>
        <x-page-header title="Orders">
            <x-button href="{{ route('orders.create') }}" size="big">Create a new order</x-button>
        </x-page-header>

        <x-box>
            <div class="px-6 pb-4 grid grid-cols-5 font-bold border-b-2 border-gray-600">
                <div>User</div>
                <div>Course</div>
                <div>Price</div>
                <div>Status</div>
                <div>Created at</div>
            </div>
            @foreach($orders as $key => $order)
                <a href="{{ route('orders.show', $order) }}"
                   class="px-6 py-4 grid grid-cols-5 bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== count($orders)) border-b border-gray-800 @endif"
                >
                    <div>{{ $order->user->name }}</div>
                    <div>{{ $order->course ? $order->course->title : $order->bundle->title }}</div>
                    <div>{{ format_money($order->price) }}</div>
                    <div>
                        <x-tag status="{{ $order->status }}"/>
                    </div>
                    <div>{{ $order->created_at }}</div>
                </a>
            @endforeach
        </x-box>

        {{ $orders->links() }}
    </x-container>
</x-app-layout>

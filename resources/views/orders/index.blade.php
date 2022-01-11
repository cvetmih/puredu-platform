<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orders
        </h2>
    </x-slot>

    <x-container>
        <div class="grid grid-cols-5 font-bold">
            <div>User</div>
            <div>Course</div>
            <div>Price</div>
            <div>Status</div>
            <div>Created at</div>
        </div>
        @foreach($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="grid grid-cols-5">
                <div>{{ $order->user->name }}</div>
                <div>{{ $order->course->title }}</div>
                <div>{{ $order->price }}</div>
                <div>{{ $order->status }}</div>
                <div>{{ $order->created_at }}</div>
            </a>
        @endforeach

        <div class="mt-4">
            <a href="{{ route('orders.create') }}" class="bg-gray-200 py-2 px-4 border-2 border-gray-300">Create
                new</a>
        </div>
    </x-container>
</x-app-layout>

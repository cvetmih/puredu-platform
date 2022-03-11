<x-app-layout>
    <x-container>
        <x-page-header title="Order #{{ $order->id }}"
                       backlink="{{ route('orders.index') }}"
                       back="Back to orders"
        >
            <x-button href="{{ route('orders.edit', $order) }}" size="big">Edit order</x-button>
        </x-page-header>

        <div class="mb-4">
            <x-tag status="{{ $order->status }}"/>
        </div>


        <x-box>
            <b>User:</b> <a href="{{ route('users.show', $order->user) }}"
                            class="underline hover:no-underline">{{ $order->user->name }}</a><br>
            <b>Course:</b> <a href="{{ route('courses.show', $order->course) }}"
                              class="underline hover:no-underline">{{ $order->course->title }}</a><br>
            <b>Price:</b> {{ format_money($order->price) }}<br>
            <b>Method:</b> {{ $order->method }}<br>
            <b>Referrer:</b> {{ $order->referrer }}<br>
            <b>Created At:</b> {{ $order->created_at }}<br>
        </x-box>
    </x-container>
</x-app-layout>

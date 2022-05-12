<x-app-layout>
    <x-container>
        <x-page-header title="Coupon #{{ $coupon->id }}"
                       backlink="{{ route('coupons.index') }}"
                       back="Back to coupons"
        >
            <x-button href="{{ route('coupons.edit', $coupon) }}" size="big">Edit coupon</x-button>
        </x-page-header>

        <div class="mb-4">
            <x-tag status="{{ $coupon->status }}"/>
        </div>


        <x-box>
            <b>Name:</b> {{ $coupon->name }}<br>
            <b>Created At:</b> {{ $coupon->created_at }}<br>
        </x-box>
    </x-container>
</x-app-layout>

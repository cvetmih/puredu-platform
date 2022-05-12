<x-app-layout>
    <x-container>
        <x-page-header title="Edit: Coupon #{{ $coupon->id }}"
                       backlink="{{ route('coupons.show', $coupon) }}"
                       back="Back to Coupon #{{ $coupon->id }}"
        />

        <x-form action="{{ route('coupons.update', $coupon) }}"
                method="post"
                :inputs="$inputs"
                :data="$coupon"
                submit="Save coupon"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

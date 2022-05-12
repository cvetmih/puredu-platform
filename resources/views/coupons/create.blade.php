<x-app-layout>
    <x-container>
        <x-page-header title="Create a new coupon"
                       backlink="{{ route('coupons.index') }}"
                       back="Back to coupons"
        />


        <x-form action="{{ route('coupons.store') }}"
                method="post"
                :inputs="$inputs"
                submit="Create coupon"
        />
    </x-container>
</x-app-layout>

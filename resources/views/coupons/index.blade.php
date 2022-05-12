<x-app-layout>
    <x-container>
        <x-page-header title="Coupons">
            <x-button href="{{ route('coupons.create') }}" size="big">Create a new coupon</x-button>
        </x-page-header>

        <x-box>
            <div class="px-6 pb-4 grid grid-cols-1 font-bold border-b-2 border-gray-600">
                <div>Name</div>
            </div>
            @foreach($coupons as $key => $coupon)
                <a href="{{ route('coupons.show', $coupon) }}"
                   class="px-6 py-4 grid grid-cols-1 bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== count($coupons)) border-b border-gray-800 @endif"
                >
                    {{ $coupon->name }}
                </a>
            @endforeach
        </x-box>
    </x-container>
</x-app-layout>

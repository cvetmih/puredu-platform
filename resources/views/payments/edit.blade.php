<x-app-layout>
    <x-container>
        <x-page-header title="Edit: Payment #{{ $payment->id }}"
                       backlink="{{ route('payments.show', $payment) }}"
                       back="Back to Payment #{{ $payment->id }}"
        />

        <x-form action="{{ route('payments.update', $payment) }}"
                method="post"
                :inputs="$inputs"
                :data="$payment"
                submit="Save payment"
        >
            {{ method_field('PUT') }}
        </x-form>
    </x-container>
</x-app-layout>

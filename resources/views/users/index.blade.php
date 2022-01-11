<x-app-layout>
    <x-container>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold mb-4">Users</h1>
            <a href="{{ route('users.create') }}"
               class="inline-flex bg-gradient-to-br from-primary to-secondary py-3 px-6 rounded-full font-bold">Create
                new</a>
        </div>

        <x-box>
            <div class="px-6 pb-4 grid grid-cols-6 font-bold">
                <div>Name</div>
                <div>Amount spent</div>
{{--                <div>Email</div>--}}
                <div>Enrollments</div>
                <div>Created at</div>
                <div>Last signed in</div>
                <div>Sign in count</div>
            </div>
            @foreach($users as $key => $user)
                <a href="{{ route('users.show', $user) }}"
                   class="px-6 py-4 grid grid-cols-6 bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== count($users)) border-b border-gray-800 @endif">
                    <div>{{ $user->name }}</div>
                    <div>${{ $user->amount_spent }}</div>
{{--                    <div>{{ $user->email }}</div>--}}
                    <div>{{ $user->enrollments_count }}</div>
                    <div>{{ $user->created_at->format('M d, Y') }}</div>
                    <div>{{ $user->last_signed_in ? $user->last_signed_in->format('M d, Y') : 'Never'}}</div>
                    <div>{{ $user->sign_in_count }}</div>
                    {{--                @dd($user)--}}
                </a>
            @endforeach
        </x-box>
    </x-container>
</x-app-layout>

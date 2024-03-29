<x-app-layout>
    <x-container>
        <x-page-header title="Users">
            <x-button href="{{ route('users.create') }}" size="big">Create a new user</x-button>
        </x-page-header>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('users.index') }}"
              class="w-full flex p-4 justify-center"
        >
            <x-input id="search"
                     type="text"
                     name="search"
                     placeholder="Search users"
                     value="{{ request('search') }}"
                     class="w-full mr-4"
            />
            @if(isset($_GET['search']))
                <x-button href="{{ route('users.index') }}"
                          theme="ghost"
                          class="mr-4"
                >
                    Clear
                </x-button>
            @endif
            <x-button type="submit">Search</x-button>
        </form>

        <x-box>
            <div class="px-6 pb-4 grid grid-cols-6 gap-4 font-bold border-b-2 border-gray-600">
                <div>Name</div>
                {{--                <div>Amount spent</div>--}}
                <div>Email</div>
                <div>Enrollments</div>
                <div>Created at</div>
                <div>Last signed in</div>
                <div>Sign in count</div>
            </div>
            @foreach($users as $key => $user)
                <a href="{{ route('users.show', $user) }}"
                   class="px-6 py-4 flex flex-col lg:grid grid-cols-6 gap-4 bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== count($users)) border-b border-gray-800 @endif">
                    <div class="overflow-hidden">{{ $user->name }}</div>
                    {{--                    <div>{{ format_money($user->amount_spent) }}</div>--}}
                    <div class="overflow-hidden">{{ $user->email }}</div>
                    <div>{{ $user->enrollments_count }}</div>
                    <div>{{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}</div>
                    <div>{{ $user->last_signed_in ? $user->last_signed_in->format('M d, Y') : 'Never'}}</div>
                    <div>{{ $user->sign_in_count }}</div>
                    {{--                @dd($user)--}}
                </a>
            @endforeach
        </x-box>

        {{ $users->links() }}
    </x-container>
</x-app-layout>

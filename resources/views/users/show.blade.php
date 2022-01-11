<x-app-layout>

    <x-container>
        <x-back href="{{ route('users.index') }}">Back to users</x-back>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold mb-4">{{ $user->name }}</h1>
        </div>

        <nav class="flex gap-4 mb-4">

            <button type="button"
                    class="py-2 px-6 font-bold bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg">
                Details
            </button>
            <button type="button"
                    class="py-2 px-6 font-bold bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg">Enrollments
            </button>
            <button type="button"
                    class="py-2 px-6 font-bold bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg">Activity feed
            </button>
            <button type="button"
                    class="py-2 px-6 font-bold bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg">Feedback
            </button>
        </nav>

        <x-box class="mb-8">
            <header class="mb-4 flex items-start justify-between">
                <h2 class="text-2xl font-bold">User profile</h2>
                <a href="{{ route('users.edit', $user) }}"
                   class="inline-flex bg-gradient-to-br from-green-400 to-blue-400 py-3 px-6 rounded-full font-bold">Edit</a>
            </header>

            <div class="flex flex-col gap-4">

                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-lg font-bold">Email</p>
                        <a href="mailto:{{ $user->email }}" class="text-pink-500">{{ $user->email }}</a>
                    </div>
                    <div class="flex-1">
                        <p class="text-lg font-bold">Sign in count</p>
                        <p class="">{{ $user->sign_in_count }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-lg font-bold">Joined</p>
                        <p class="">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-lg font-bold">Last login</p>
                        <p class="">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

            </div>
        </x-box>


        <x-box class="mb-8">
            <header class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Enrollments</h2>
            </header>

            <form class="flex items-end mb-4 gap-4" method="post" action="{{ route('users.enroll', $user) }}">
                @csrf
                <div class="flex flex-col gap-2 flex-1">
                    <label for="course_id" class="text-sm font-bold">Enroll {{ $user->name }} in</label>
                    <select name="course_id" id="course_id"
                            class="border border-gray-700 bg-white bg-opacity-5 block rounded-lg py-3 px-4 text-md w-full text-white text-opacity-70 focus:text-opacity-100 @error('course_id') border-pink-600 @enderror">
                        <option value=""></option>
                        @foreach($courses as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <button
                    type="submit"
                    class="inline-flex bg-gradient-to-br from-green-400 to-blue-400 py-3 px-6 rounded-full font-bold">
                    Enroll
                </button>
            </form>

            <x-box>
                @foreach($user->courses as $key => $course)
                    <div
                        class="px-6 py-4 flex gap-4 justify-between bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== count($user->courses)) border-b border-gray-800 @endif">
                        <div>{{ $course->title }}</div>
                        <div>0%</div>
                        <button class="cursor-pointer py-2">
                            <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M2 4C3.10457 4 4 3.10457 4 2C4 0.89543 3.10457 0 2 0C0.89543 0 0 0.89543 0 2C0 3.10457 0.89543 4 2 4Z"
                                      fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M9 4C10.1046 4 11 3.10457 11 2C11 0.89543 10.1046 0 9 0C7.89543 0 7 0.89543 7 2C7 3.10457 7.89543 4 9 4Z"
                                      fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 4C17.1046 4 18 3.10457 18 2C18 0.89543 17.1046 0 16 0C14.8954 0 14 0.89543 14 2C14 3.10457 14.8954 4 16 4Z"
                                      fill="white"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </x-box>
        </x-box>

        <x-box class="mb-8">
            <header class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Activity feed</h2>
            </header>

            <x-box>
                @foreach($user->activities as $key => $activity)
                    <div
                        class="px-6 py-4 flex gap-4 justify-between bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== $user->activities->count()) border-b border-gray-800 @endif">
                        <div>{{ $activity->course->title }}</div>
                        <div>[{{ $activity->lesson->icon }}] {{ $activity->lesson->title }}</div>
                        <div>{{ $activity->created_at }}</div>
                    </div>
                @endforeach
            </x-box>
        </x-box>

        <x-box>
            <header class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Feedback</h2>
            </header>

            <p>Add feedback from user here.</p>
        </x-box>


    </x-container>
</x-app-layout>

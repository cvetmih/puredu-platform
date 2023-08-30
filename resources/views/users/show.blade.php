<x-app-layout>

    <x-container data-tabs>
        <x-page-header title="{{ $user->name }}"
                       backlink="{{ route('users.index') }}"
                       back="Back to users"
        />

        <nav class="flex gap-4 mb-4">
            <button type="button"
                    class="py-2 px-6 font-bold rounded-lg bg-gradient-to-br from-pink-400 to-purple-500"
                    data-tabs-nav="details"
            >
                Details
            </button>
            <button type="button"
                    class="py-2 px-6 font-bold rounded-lg bg-white bg-opacity-10 hover:bg-opacity-20"
                    data-tabs-nav="enrollments"
            >Enrollments
            </button>
            <button type="button"
                    class="py-2 px-6 font-bold rounded-lg bg-white bg-opacity-10 hover:bg-opacity-20"
                    data-tabs-nav="activity"
            >Activity feed
            </button>
            <button type="button"
                    class="py-2 px-6 font-bold rounded-lg bg-white bg-opacity-10 hover:bg-opacity-20"
                    data-tabs-nav="feedback"
            >Feedback
            </button>
        </nav>

        <div class="flex flex-col gap-8">
            <x-box data-tab="details" class="active">
                <header class="mb-4 flex items-start justify-between">
                    <h2 class="text-2xl font-bold">User profile</h2>
                    <x-button href="{{ route('users.edit', $user) }}"
                              theme="secondary"
                              class="rounded-full"
                              size="big"
                    >
                        Edit
                    </x-button>
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

                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-lg font-bold">Total spent</p>
                            <p class="">${{ $total_spent }}</p>
                        </div>
                        <div class="flex-1">
                            <p class="text-lg font-bold">Last order at</p>
                            <p class="">{{ $last_order_at ? $last_order_at->format('M d, Y') : '-' }}</p>
                        </div>
                    </div>

                </div>
            </x-box>


            <x-box data-tab="enrollments">
                <header class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Enrollments</h2>
                </header>

                <form class="flex items-end mb-4 gap-4" method="post" action="{{ route('users.enroll', $user) }}">
                    @csrf
                    <div class="flex flex-col gap-2 flex-1">
                        <label for="course_id" class="text-sm font-bold">Enroll {{ $user->name }} in</label>
                        <x-select name="course_id" id="course_id"
                                  class="{{ $errors->has('course_id') ? 'border-pink-600' :'' }}"
                        >
                            <option value=""></option>
                            @foreach($courses as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <x-button type="submit" size="big">Enroll</x-button>
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

            <x-box data-tab="activity">
                <header class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Activity feed</h2>
                </header>

                <x-box>
                    @foreach($trackers as $key => $tracker)
                        <div
                            class="px-6 py-4 flex flex-col gap-4 bg-gradient-to-br hover:from-primary hover:to-secondary @if($key + 1 !== $user->trackers->count()) border-b border-gray-800 @endif">
                            {{--                            <div>{{ $tracker->action }}</div>--}}
                            {{--                            <div class="inline-flex items-center gap-2">--}}
                            {{--                                <div class="w-4">--}}
                            {{--                                    <x-icon icon="{{ $activity->lesson->icon }}"/>--}}
                            {{--                                </div>--}}
                            {{--                                {{ $activity->lesson->title }}--}}
                            {{--                            </div>--}}
                            <div>
                                <x-tag status="{{ $tracker->action }}"/>
                            </div>
                            <div>{{ json_encode($tracker->body) }}</div>
                        </div>
                    @endforeach
                </x-box>

                {{ $trackers->links() }}
            </x-box>

            <x-box data-tab="feedback">
                <header class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Feedback</h2>
                </header>

                <p>Add feedback from user here.</p>
            </x-box>
        </div>


    </x-container>
</x-app-layout>

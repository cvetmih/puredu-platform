<x-app-layout>
    <x-container>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <x-box class="flex flex-col gap-4 flex-1">
                    <x-box class="bg-white bg-opacity-5 flex gap-8 justify-between">
                        <div>
                            <p class="mb-4 text-sm text-gray-200">Monthly revenue</p>
                            <p class="text-4xl font-bold">{{ $this_month_revenue }}</p>
                        </div>
                        <svg width="151" height="78" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect y="9" width="16" height="68.5" rx="8" fill="url(#a)" fill-opacity=".1"/>
                            <rect x="22" y="9" width="15.2" height="68.5" rx="7.6" fill="url(#b)" fill-opacity=".1"/>
                            <rect x="45" width="15.2" height="68.5" rx="7.6" fill="url(#c)" fill-opacity=".1"/>
                            <rect x="67" y="9" width="16" height="68.5" rx="8" fill="url(#d)" fill-opacity=".8"/>
                            <rect x="90" width="15.2" height="68.5" rx="7.6" fill="url(#e)" fill-opacity=".1"/>
                            <rect x="112" y="9" width="15.2" height="68.5" rx="7.6" fill="url(#f)" fill-opacity=".1"/>
                            <rect x="135" y="9" width="15.2" height="68.5" rx="7.6" fill="url(#g)" fill-opacity=".1"/>
                            <defs>
                                <linearGradient id="a" x1="-7.3" y1="54.2" x2="28.5" y2="62.6"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                                <linearGradient id="b" x1="15.1" y1="54.2" x2="49.2" y2="61.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                                <linearGradient id="c" x1="38.1" y1="45.2" x2="72.2" y2="52.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                                <linearGradient id="d" x1="59.7" y1="54.2" x2="95.5" y2="62.6"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                                <linearGradient id="e" x1="83.1" y1="45.2" x2="117.2" y2="52.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                                <linearGradient id="f" x1="105.1" y1="54.2" x2="139.2" y2="61.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                                <linearGradient id="g" x1="128.1" y1="54.2" x2="162.2" y2="61.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFB929"/>
                                    <stop offset="1" stop-color="#FF7DC1"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </x-box>

                    <x-box class="bg-white bg-opacity-5 flex gap-8 justify-between">
                        <div>
                            <p class="mb-4 text-sm text-gray-200">Orders this month</p>
                            <p class="text-4xl font-bold">{{ $orders_this_month }}</p>
                        </div>
                        <svg width="151" height="76" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity=".1" y="7" width="16" height="68.5" rx="8" fill="url(#paint0_linear)"/>
                            <rect x="22" y="7" width="15.2" height="68.5" rx="7.6" fill="url(#paint1_linear)"/>
                            <rect opacity=".1" x="45" width="15.2" height="68.5" rx="7.6" fill="url(#paint2_linear)"/>
                            <rect opacity=".1" x="67" y="7" width="16" height="68.5" rx="8" fill="url(#paint3_linear)"/>
                            <rect opacity=".1" x="90" width="15.2" height="68.5" rx="7.6" fill="url(#paint4_linear)"/>
                            <rect opacity=".1" x="112" y="7" width="15.2" height="68.5" rx="7.6"
                                  fill="url(#paint5_linear)"/>
                            <rect opacity=".1" x="135" width="15.2" height="68.5" rx="7.6" fill="url(#paint6_linear)"/>
                            <defs>
                                <linearGradient id="paint0_linear" x1="-7.3" y1="52.2" x2="28.5" y2="60.6"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear" x1="15.1" y1="52.2" x2="49.2" y2="59.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                                <linearGradient id="paint2_linear" x1="38.1" y1="45.2" x2="72.2" y2="52.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                                <linearGradient id="paint3_linear" x1="59.7" y1="52.2" x2="95.5" y2="60.6"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                                <linearGradient id="paint4_linear" x1="83.1" y1="45.2" x2="117.2" y2="52.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                                <linearGradient id="paint5_linear" x1="105.1" y1="52.2" x2="139.2" y2="59.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                                <linearGradient id="paint6_linear" x1="128.1" y1="45.2" x2="162.2" y2="52.8"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF7DC1"/>
                                    <stop offset="1" stop-color="#4244FF"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </x-box>

                    <x-box class="bg-white bg-opacity-5 flex gap-8 justify-between">
                        <div>
                            <p class="mb-4 text-sm text-gray-200">Users this month</p>
                            <p class="text-4xl font-bold">{{ $users_this_month }}</p>
                        </div>

                        <svg width="151" height="78" viewBox="0 0 151 78" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" y="9" width="16.0428" height="68.4815" rx="8.02139"
                                  fill="url(#paint0_linear2)"/>
                            <rect opacity="0.3" x="22" y="9" width="15.2406" height="68.4815" rx="7.62032"
                                  fill="url(#paint1_linear2)"/>
                            <rect opacity="0.3" x="45" width="15.2406" height="68.4815" rx="7.62032"
                                  fill="url(#paint2_linear2)"/>
                            <rect x="67" y="9" width="16.0428" height="68.4815" rx="8.02139"
                                  fill="url(#paint3_linear2)"/>
                            <rect opacity="0.3" x="90" width="15.2406" height="68.4815" rx="7.62032"
                                  fill="url(#paint4_linear2)"/>
                            <rect opacity="0.3" x="112" y="9" width="15.2406" height="68.4815" rx="7.62032"
                                  fill="url(#paint5_linear2)"/>
                            <rect opacity="0.3" x="135" y="9" width="15.2406" height="68.4815" rx="7.62032"
                                  fill="url(#paint6_linear2)"/>
                            <defs>
                                <linearGradient id="paint0_linear2" x1="4.17243" y1="7.80693" x2="4.17243" y2="96.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear2" x1="25.9638" y1="7.80693" x2="25.9638" y2="96.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                                <linearGradient id="paint2_linear2" x1="48.9638" y1="-1.19307" x2="48.9638" y2="87.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                                <linearGradient id="paint3_linear2" x1="71.1724" y1="7.80693" x2="71.1724" y2="96.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                                <linearGradient id="paint4_linear2" x1="93.9638" y1="-1.19307" x2="93.9638" y2="87.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                                <linearGradient id="paint5_linear2" x1="115.964" y1="7.80693" x2="115.964" y2="96.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                                <linearGradient id="paint6_linear2" x1="138.964" y1="7.80693" x2="138.964" y2="96.5"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7DFFB4"/>
                                    <stop offset="1" stop-color="#4244FF" stop-opacity="0.47"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </x-box>
                </x-box>
            </div>

            <div>
                <x-box-with-header class="flex-1" header="Orders">
                    <div class="px-6">
                        @foreach($latest_orders as $order)
                            <div class="border-b border-gray-800 py-2">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="flex flex-col px-4 border-l-2 border-primary hover:translate-x-1.5 transform transition-transform"
                                >
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="mb-1">
                                                {{ $order->course ? $order->course->title : $order->bundle->title }}
                                            </div>
                                            <div class="text-sm text-gray-400">{{ $order->user->name }}</div>
                                        </div>
                                        <div>
                                            <div class="text-lg text-right">
                                                ${{ $order->price }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <a href="{{ route('orders.index') }}"
                               class="py-2 px-4 inline-flex"
                            >
                                See All
                            </a>
                        </div>
                    </div>
                </x-box-with-header>
            </div>

            <div>
                <x-box-with-header class="flex-1" header="Quick Stats">
                    <ul class="">
                        <li class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4">
                            Total revenue: {{ $total_revenue }}
                        </li>
                        <li class="bg-gradient-to-br hover:from-primary hover:to-secondary px-6 py-4">
                            Total users: {{ $total_users }}
                        </li>
                    </ul>
                </x-box-with-header>
            </div>
        </div>
    </x-container>
</x-app-layout>

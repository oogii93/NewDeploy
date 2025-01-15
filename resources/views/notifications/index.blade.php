<x-app-layout>
    @php
    $statusTranslations = [
        'pending' => '申請中',
        'approved' => '承認済み',
        'denied' => '拒否済み'
    ];

    $statusColors = [
        'pending' => 'bg-yellow-200 text-yellow-700',
        'approved' => 'bg-green-200 text-green-700',
        'denied' => 'bg-red-200 text-red-700'
    ];
    @endphp

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-3xl mt-3 px-6 py-4 text-center font-bold text-gray-700">通知</h1>

                <div class="p-6 bg-white border-b border-gray-200">
                    @forelse ($notifications as $notification)
                        <div class="mb-6 p-6 rounded-lg shadow-sm {{ $notification->read_at ? 'bg-stone-200' : 'bg-blue-100' }} transition-all duration-200 ease-in-out">



                            {{-- Car Insurance Notification --}}




                            {{-- Post Notification --}}
                            @if(isset($notification->data['post_id']))
                                <div class="flex items-center space-x-4">
                                    <div class="bg-orange-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.4 0-3.6-1.2-4.8-3C5.6 3.2 5 3 4 3s-1.6.2-2.4 2C.8 7.2 0 8.4 0 10c0 1.6 0 3.2 2 4 2 1 2.4 0 4 0s2.4 1 4 0 3.2 1.2 4 0 2.4-2.4 4-3.2C18 7.2 17 4.8 15 3S12 0 12 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-700">新規投稿通知</p>
                                        <p class="text-sm text-gray-500">
                                            投稿タイトル: <span class="font-bold">{{ $notification->data['title'] }}</span>
                                        </p>
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-blue-500 hover:text-blue-700">詳しくは</a>
                                    </div>
                                </div>

                            {{-- Time-Off Request Notification --}}
                            @elseif(isset($notification->data['user_name']) && !isset($notification->data['type']))

                                @if(auth()->user()->division_id == 6)
                                {{-- HR specific time off request notification --}}
                                <div class="flex items-center space-x-4">
                                    <div class="bg-red-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2-2 4 4M15 8l2 2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-700">
                                            <span class="bg-green-200 px-2 py-1 rounded-md">{{ $notification->data['user_name'] }}</span> さんから勤怠届がありました。
                                        </p>
                                        @if(isset($notification->data['date']))
                                            <p class="text-sm text-gray-500">日付: {{ $notification->data['date'] }}</p>
                                        @endif
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-blue-500 hover:text-blue-700">詳しくは</a>
                                    </div>
                                </div>
                                @else
                                {{-- Non HR time off request notification --}}
                                <div class="flex items-center space-x-4">
                                    <div class="bg-green-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2-2 4 4M15 8l2 2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-700">
                                            <span class="bg-green-200 px-2 py-1 rounded-md">{{ $notification->data['user_name'] }}</span> さんから勤怠届がありました。
                                        </p>
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-blue-500 hover:text-blue-700">詳しくは</a>
                                    </div>
                                </div>
                                @endif

                            {{-- Time-Off Request Status Change Notification --}}
                            @elseif(isset($notification->data['status']))
                                <div class="flex items-center space-x-4">
                                    <div class="bg-red-700 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h-4l-2 2-6-6m16 8l-3 3-6-6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-700">勤怠届通知</p>
                                        <p class="text-sm {{ $statusColors[$notification->data['status']] }} px-2 py-1 rounded-md font-bold">
                                            {{ $statusTranslations[$notification->data['status']] }}
                                        </p>
                                        <p class="text-sm text-gray-500">申請日: {{ $notification->data['date'] }}</p>
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-blue-500 hover:text-blue-700">詳しくは</a>
                                    </div>
                                </div>

                            {{-- Application2 Request Notification --}}
                            @elseif(isset($notification->data['type']) && $notification->data['type'] === 'application2')
                                <div class="flex items-center space-x-4">
                                    <div class="bg-purple-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-700">社内注文申請通知</p>

                                        <p class="text-sm text-gray-500 font-semibold">申請者: {{ $notification->data['user_name'] }}</p>
                                        <p class="text-sm text-gray-500 font-semibold">
                                            申請日時: {{ \Carbon\Carbon::parse($notification->data['created_at'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i') }}
                                        </p>
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                            詳しくは
                                        </a>
                                    </div>
                                </div>
                            @endif

                         @if(isset($notification->data['number_plate']) && isset($notification->data['insurance_end_date']))
                         <div class="flex items-center space-x-4">
                            <div class="bg-orange-100 p-3 rounded-full">
                                <svg
                                class="w-6 h-6"
                                viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>car [#640]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-380.000000, -5359.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M342,5214 L341.241,5214 C340.692,5213.39 339.895,5213 339.01,5213 C338.657,5213 338,5213.072 338,5213.184 L338,5212 L342,5212 L342,5214 Z M339.02,5217 C338.468,5217 338.02,5216.551 338.02,5216 C338.02,5215.449 338.468,5215 339.02,5215 C339.571,5215 340.02,5215.449 340.02,5216 C340.02,5216.551 339.571,5217 339.02,5217 L339.02,5217 Z M326,5210 L336,5210 L336,5201 L326,5201 L326,5210 Z M336,5214 L331.241,5214 C330.692,5213.39 329.905,5213 329.02,5213 C328.134,5213 327.347,5213.39 326.798,5214 L326,5214 L326,5212 L336,5212 L336,5214 Z M329.02,5217 C328.468,5217 328.02,5216.551 328.02,5216 C328.02,5215.449 328.468,5215 329.02,5215 C329.571,5215 330.02,5215.449 330.02,5216 C330.02,5216.551 329.571,5217 329.02,5217 L329.02,5217 Z M338,5210 L338,5199 L324,5199 L324,5216 L326.02,5216 C326.02,5217.657 327.363,5219 329.02,5219 C330.676,5219 332.02,5217.657 332.02,5216 L336.02,5216 C336.02,5217.657 337.363,5219 339.02,5219 C340.676,5219 342.02,5217.657 342.02,5216 L344,5216 L344,5210 L338,5210 Z" id="car-[#640]"> </path> </g> </g> </g> </g></svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-700">車両保険期間通知</p>

                                <p class="text-sm text-gray-500 font-semibold">車両番号: {{ $notification->data['number_plate'] }}</p>
                                <p class="text-sm text-gray-500 font-semibold">保険期限: {{ $notification->data['insurance_end_date'] }}</p>

                                <a href="{{ route('notifications.markAsRead', $notification->id) }}"
                                class="text-blue-500 hover:text-blue-700">
                                    詳しくは
                                </a>
                            </div>


                                {{-- <p class="text-sm text-gray-500">車両番号: {{ $notification->data['number_plate'] }}</p>
                                <p class="text-sm text-gray-500">保険期限: {{ $notification->data['insurance_end_date'] }}</p>

                                <a href="{{ route('notifications.markAsRead', $notification->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                        詳しくは
                                    </a> --}}

                            </div>
                        @endif





                        </div>
                    @empty
                        <p class="text-sky-500">通知がありません。</p>
                    @endforelse

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</x-app-layout>

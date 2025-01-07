<div class="overflow-x-auto px-5 ">
<table class="border-collapse border border-slate-400 min-w-full bg-white">
    <!-- Table header -->

    <!--asdafds-->

    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-sky-200">
                    <tr class="">

                        <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">申請Id</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">送信日付け</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">返事日付け</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">送信先上司</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">状態</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($applications as $application)
                        <tr class="hover:bg-stone-100">
                            <td class="border border-gray-300 px-4 py-4">
                                <div class="text-sm text-gray-900">{{ $application->id }}</div>
                            </td>





                            <td class="border border-gray-300 px-4 py-4">
                                <div class="text-sm text-gray-900">{{ $application->created_at->translatedFormat('Y年n月j日') }}</div>
                            </td>
                            <td class="border border-gray-300 px-4 py-4">
                                <div class="text-sm text-gray-900">{{ $application->updated_at->translatedFormat('Y年n月j日') }}</div>
                            </td>
                            <td class="border border-gray-300 px-4 py-4">
                                <div class="text-sm text-gray-900">{{ $application->boss->name ?? 'N/A' }}</div>
                            </td>

                            <td class="border border-gray-300 px-4 py-4">
                                @if($application->status == 'approved')
                                <div class="flex items-center">
                                    <span class="inline-block text-xs font-semibold text-white bg-green-500 px-1 py-1 md:px-2 md:py-2 rounded-lg md:rounded-xl whitespace-nowrap">
                                        承認済み
                                    </span>
                                    <img src="{{ asset('images/approved.png') }}" alt="Approved" class="ml-2 w-8 h-8 md:w-10 md:h-10">

                                </div>
                                @elseif($application->status == 'denied')
                                <div class="flex items-center">
                                    <span class="inline-block text-xs font-semibold text-white bg-rose-500 px-1 py-1 md:px-2 md:py-2 rounded-lg md:rounded-xl whitespace-nowrap">
                                        拒否
                                    </span>
                                    <img src="{{ asset('images/denied.png') }}" alt="Denied" class="ml-2 w-8 h-8 md:w-10 md:h-10">

                                </div>
                                @else
                                    @php
                                        $statusTranslations=[
                                            'pending'=>'承認待ち'
                                        ];

                                    @endphp

                    <span class="inline-block text-xs font-semibold text-white bg-orange-400 px-1 py-1 md:px-2 md:py-2 rounded-lg md:rounded-xl whitespace-nowrap">
                                            {{ $statusTranslations[$application->status] ?? $application->status }}</span>

                                @endif
                            </td>


                            <td class="border border-gray-300 px-4 py-4">



                                    <a href="{{ route('applications.show', $application) }}"
                                        class="text-sky-600 hover:text-sky-800 transition duration-300 ease-in-out transform hover:scale-110">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                         </svg>
                                     </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $applications->links() }}
    </div>

    <!--fdsafasdf-->



    {{-- <div class="md:px-10 py-8 w-full">
        <div class="shadow overflow-hidden rounded border-b border-gray-200">
            <table class="border-collapse border border-slate-400 min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">申請ID</th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">社員名</th>

                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">
                            Application ID</th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">送信日付け
                        </th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">返事日付け
                        </th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">送信先上司</th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">状態</th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">actions
                        </th>
                        <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">comment
                        </th>
                    </tr>
    <tbody class="text-gray-700">

        @foreach ($applications as $application)
        <tr class="border-b border-gray-200 hover:bg-gray-200">

            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">{{ $application->id }}</td>
            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">{{ $application->user->name }}</td>


            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2 whitespace-nowrap hidden md:table-cell">{{ $application->applicationable_id }}</td>
            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2 whitespace-nowrap hidden md:table-cell">{{ $application->created_at }}</td>
            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2 whitespace-nowrap hidden md:table-cell">{{ $application->updated_at }}</td>
            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">{{ $application->boss->name ?? 'N/A' }}</td>
            <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">
                @if ($application->status == 'approved')
                    <div class="flex items-center">
                        <span>{{ $application->status }}</span>
                        <img src="{{ asset('images/approved.png') }}" alt="Approved"
                            class="ml-2 w-10 h-10">
                    </div>
                @elseif($application->status == 'denied')
                    <div class="flex items-center">
                        <span>{{ $application->status }}</span>
                        <img src="{{ asset('images/denied.png') }}" alt="Denied"
                            class="ml-2 w-10 h-10">
                    </div>
                @else
                    <span>{{ $application->status }}</span>
                @endif
            </td>




            <td class="border border-slate-300 px-4 py-2">
                <a href="{{ route('applications.show', $application) }}"
                    class="text-blue-500 hover:underline">View</a>
            </td>
            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap hidden md:table-cell">
            </td>


        </tr>
    @endforeach
    </tbody>
</table>


</div> --}}

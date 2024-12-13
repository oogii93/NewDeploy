
<x-app-layout>

    @if (session('success') || session('error'))
<div id="statusToast" class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
<div class="bg-gray-100 border-l-4 @if(session('success')) border-blue-500 @else border-red-500 @endif rounded-r-lg shadow-md overflow-hidden">
    <div class="p-4 flex items-center">
        <div class="flex-shrink-0">
            @if (session('success'))
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @else
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
        </div>
        <div class="ml-3 w-0 flex-1">
            @if (session('success'))
                <p class="text-lg font-semibold text-blue-900">
                    {!! session('success') !!}
                </p>
            @endif
            @if (session('error'))
                <p class="text-sm font-medium text-gray-900">
                    {{ session('error') }}
                </p>
            @endif


        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button id="closeToast" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
            閉じる
        </button>
    </div>
</div>
</div>

<style>
@keyframes slideDown {
    from { transform: translate(-50%, -100%); }
    to { transform: translate(-50%, 0); }
}
#statusToast {
    animation: slideDown 0.5s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var statusToast = document.getElementById('statusToast');
    var closeToast = document.getElementById('closeToast');

    var hideTimeout = setTimeout(function() {
        hideToast();
    }, 8000);

    closeToast.addEventListener('click', function() {
        clearTimeout(hideTimeout);
        hideToast();
    });

    function hideToast() {
        statusToast.style.transform = 'translate(-50%, -100%)';
        statusToast.style.transition = 'transform 0.5s ease-in-out';
        setTimeout(function() {
            statusToast.style.display = 'none';
        }, 500);
    }
});
</script>
@endif
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 bg-gradient-to-r from-sky-600 to-blue-600 p-5 rounded-xl px-10 py-10">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-white">
                        勤怠届上司管理
                    </h1>
                    <p class="mt-4 text-sm text-white">
                        勤怠届一覧
                    </p>
                </div>

            </div>





            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <!-- Search and Filter Section -->
            <div class="mt-10 px-10">

                <form action="{{ route('time_off_boss.index') }}" method="GET" class="mb-4">
                    <input type="hidden" name="" value="">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="text" name="search" value="" class="border border-gray-300 rounded px-3 py-2 flex-grow" placeholder="商品番号、商品名、種類、メーカーで検索">
                        <x-button purpose="default" type="submit">
                            検索
                        </x-button>
                    </div>

                </form>

            </div>


                {{-- <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="検索...">
                                <button type="submit" class="ml-2 px-4 py-2 bg-indigo-500 text-white rounded-lg">Search</button>
                            </div>
                        </form>



                    </div>
                </div> --}}



                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-200 border ">
                            <tr class="border-gray-300">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    順番
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    送信人
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    勤怠区分
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    日付
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    理由１
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    理由２
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    送信日付け
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    状態
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    動作
                                </th>

                            </tr>
                        </thead>






                        </tr>
                        <tbody class="bg-white divide-y divide-gray-100 ">
                            @foreach ($timeOffRequestRecords as $record)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    {{  $record->id}}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->user ? $record->user->name : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->attendanceTypeRecord ? $record->attendanceTypeRecord->name : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->date }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->reason_select }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->reason }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->created_at }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        @switch(strtolower($record->status))
                                            @case('pending')
                                                承認待ち
                                                @break
                                            @case('approved')
                                                承認済み
                                                @break
                                            @default
                                                {{ $record->status }}
                                        @endswitch
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <form action="{{ route('time_off_boss.updateStatus', $record->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <button type="submit" name="status" value="approved"
                                            class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded {{ $record->status !== 'pending' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $record->status !== 'pending' ? 'disabled' : '' }}>
                                            承認
                                        </button>
                                        <button type="submit" name="status" value="denied"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded {{ $record->status !== 'pending' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $record->status !== 'pending' ? 'disabled' : '' }}>
                                            拒否
                                        </button>
                                        @if($record->status === 'pending')
                                            <select name="division_id" id="division_id" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                <option value="">会社選択</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </form>
                                </td>



                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $timeOffRequestRecords->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




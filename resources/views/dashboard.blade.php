<x-app-layout>
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            width: 100%;
        }

        @media (max-width: 768px) {
            .table-responsive {
                width: auto;
                margin: 0 auto;
            }

            .table-responsive table {
                width: 100%;
                min-width: auto;
                /* Adjust this value based on your table's width */
            }




            th,
            td {
                font-size: 10px;
                /* Adjust the font size for table headers and cells */
                /* padding: 1px; */
                white-space: nowrap;
                /* Adjust the padding for table headers and cells */
            }

            th:nth-child(1),
            td:nth-child(1),
            th:nth-child(2),
            td:nth-child(2),
            th:nth-child(3),
            td:nth-child(3),
            th:nth-child(4),
            td:nth-child(4),
            th:nth-child(5),
            td:nth-child(5),
            th:nth-child(6),
            td:nth-child(6),
            th:nth-child(7),
            td:nth-child(7) {
                /* width: 14.28%; Adjusted to fit 7 columns */
                max-width: 50px;
                Limit maximum width
                /* overflow: hidden; */
                /* text-overflow: ellipsis; */
            }


        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/ja.min.js"></script>
    <div class="card-body">

        <div class="flex justify-end bg-gray-100">


            <div class="py-4 px-4 flex items-center">



                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                        clip-rule="evenodd" />
                </svg>
                <span class=" text-bold text-l text-black ml-2">{{ auth()->user()->name }}{{ __(' 様') }}</span>
            </div>
        </div>


        <div class="py-12 bg-gray-100 overflow-hidden shadow-sm">




            <div class="max-w-sm mx-auto px-8">





                <div class="bg-white p-6 rounded-md shadow-md max-w-2xl mx-auto font-sans mt-3">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">勤怠記録</h2>
                    <form id="timeRecordForm" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="button" id="buttonValue">

                        <div class="text-center">
                            <input value="{{ now()->format('Y-m-d H:i') }}" type="datetime-local" name="recorded_at"
                                id="recordedAt"
                                class="form-input w-full max-w-md bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-md focus:ring-blue-500 focus:border-blue-500 p-3"
                                lang="ja">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button"
                                class="btn-primary bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-md transition duration-300 ease-in-out"
                                data-value="ArrivalRecord">
                                出勤
                            </button>
                            <button type="button"
                                class="btn-primary bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-md transition duration-300 ease-in-out"
                                data-value="DepartureRecord">
                                退勤
                            </button>
                        </div>

                        @if (auth()->user()->office && auth()->user()->office->corp && auth()->user()->office->corp->corp_name === 'ユメヤ')
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="text-center mb-3 font-semibold text-gray-700">ユメヤ専用</p>
                                <p class="text-center mb-3 text-sm text-gray-600">二回目出勤する場合は押してください</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" data-value="SecondArrivalRecord"
                                        class="btn-secondary bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-md transition duration-300 ease-in-out">
                                        二回出勤
                                    </button>
                                    <button type="button" data-value="SecondDepartureRecord"
                                        class="btn-secondary bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-md transition duration-300 ease-in-out">
                                        二回退勤
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" id="startBreakButton" data-value="StartBreak"
                                class="btn-secondary bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 px-6 rounded-md transition duration-300 ease-in-out">
                                休憩開始
                            </button>
                            <button type="button" id="endBreakButton" data-value="EndBreak"
                                class="btn-secondary bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-md transition duration-300 ease-in-out">
                                休憩終了
                            </button>
                        </div>
                    </form>
                </div>












                @if (session('status') || session('error'))
                <div id="statusToast" class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
                    <div class="bg-white border-l-4 @if(session('status')) border-blue-500 @else border-red-500 @endif rounded-r-lg shadow-md overflow-hidden">
                        <div class="p-4 flex items-center">
                            <div class="flex-shrink-0">
                                @if (session('status'))
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                @if (session('status'))
                                    <p class="text-lg font-semibold text-blue-900">
                                        {!! session('status') !!}
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


            </div>
        </div>


    </div>



    <div class="flex justify-between py-6 bg-white">
        <a href="{{ route('dashboard.previous-month') }}"
            class="bg-zinc-500 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded">先月</a>

        <input type="text" class="text-center py-2 px-4 bg-gray-200 text-gray-800 font-semibold rounded"
            value="{{ \Carbon\Carbon::now()->day >= 1 && \Carbon\Carbon::now()->day <= 16? \Carbon\Carbon::createFromDate(session('current_year', \Carbon\Carbon::now()->year), session('current_month', \Carbon\Carbon::now()->month))->format('Y年n月'): \Carbon\Carbon::createFromDate(session('current_year', \Carbon\Carbon::now()->year), session('current_month', \Carbon\Carbon::now()->month))->addMonths()->format('Y年n月') }}"
            disabled>



        <a href="{{ route('dashboard.next-month') }}"
            class="bg-orange-200 hover:bg-orange-300 font-bold py-2 px-4 rounded">次月</a>
    </div>


    <div class="bg-white">

        <div class="table-responsive bg-white max-w-6xl mx-auto shadow-lg rounded-2xl overflow-hidden mb-10">
            <div class="overflow-y-auto">
                <table class="min-w-full table-auto border border-slate-400 text-sm md:text-base">
                    <thead class="bg-blue-200 text-gray-700 sticky top-0 z-10 shadow-md">
                        <tr>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[80px] md:min-w-[100px]">
                                <span class="block text-xs md:text-sm">日付け</span>
                            </th>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[80px] md:min-w-[100px]">
                                <span class="block text-xs md:text-sm">勤怠区分</span>
                            </th>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[60px] md:min-w-[80px]">
                                <span class="block text-xs md:text-sm">外出</span>
                            </th>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px]">
                                <span class="block text-xs md:text-sm">出社時間</span>
                            </th>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px]">
                                <span class="block text-xs md:text-sm">退社時間</span>
                            </th>

                            @if (auth()->user()->office && auth()->user()->office->corp && auth()->user()->office->corp->corp_name === 'ユメヤ')
                                <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px]">
                                    <span class="block text-xs md:text-sm">二回出席</span>
                                </th>
                                <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px]">
                                    <span class="block text-xs md:text-sm">二回退勤</span>
                                </th>
                            @endif

                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px]">
                                <span class="block text-xs md:text-sm">労働時間</span>
                            </th>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px]">
                                <span class="block text-xs md:text-sm">残業時間</span>
                            </th>
                            <th class="border border-slate-400 p-2 md:p-3 font-semibold whitespace-normal min-w-[90px] md:min-w-[110px] hidden md:table-cell">
                                <span class="block text-xs md:text-sm">残業時間2</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
                        @if ($tbody && !empty($tbody))
                            {!! $tbody !!}
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-600">No records available.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


    </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('timeRecordForm');
            const buttons = form.querySelectorAll('button[type="button"]');
            const buttonValueInput = document.getElementById('buttonValue');
            const dateInput = document.getElementById('recordedAt');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {

                    console.log('Button clicked:', this.getAttribute('data-value'));
                    e.preventDefault();
                    const recordType = this.getAttribute('data-value');
                    let selectedDateTime = dateInput.value;

                    if (!selectedDateTime) {
                        alert('日時を選択してください。');
                        return;
                    }

                    switch (recordType) {
                        case 'StartBreak':
                            handleStartBreak(recordType, selectedDateTime);

                            break;
                        case 'EndBreak':
                            handleEndBreak(recordType, selectedDateTime);
                            break;
                        case 'ArrivalRecord':
                            handleArrivalRecord(recordType, selectedDateTime);
                            break;
                        case 'SecondArrivalRecord':
                            handleArrivalRecord(recordType, selectedDateTime);
                            break;
                        case 'DepartureRecord':
                            handleDepartureRecord(recordType, selectedDateTime);
                            break;
                        case 'SecondDepartureRecord':
                            handleDepartureRecord(recordType, selectedDateTime);
                            break;
                        default:
                            submitForm(recordType, selectedDateTime);
                    }
                });
            });

            function handleStartBreak(recordType, selectedDateTime) {
                fetch(`/check-break-status?date=${selectedDateTime}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.canStartBreak) {
                            submitForm(recordType, selectedDateTime);
                        } else {
                            alert(data.message);
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert(' an error ');
                    });
            }

            function handleEndBreak(recordType, selectedDateTime) {
                fetch(`/check-break-status?date=${selectedDateTime}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.breakCount > 0 && !data.canStartBreak) {
                            if (confirm('本当に休憩終了時間を記録しますか?')) {
                                submitForm(recordType, selectedDateTime);
                            }
                        } else {
                            alert('現在進行中の休憩はありません。');
                        }
                    });
            }

            function handleArrivalRecord(recordType, selectedDateTime) {
                fetch(`/check-record/${recordType}?date=${selectedDateTime}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.exists == 1) {
                            if (confirm('本当に出勤時間を変更しますか?')) {
                                submitForm(recordType, selectedDateTime);
                            }
                        } else if (data.exists == 2) {
                            alert('二回目出勤時間は必ず一回目退勤時間以降になります');
                        } else {
                            submitForm(recordType, selectedDateTime);
                        }
                    });
            }

            function handleDepartureRecord(recordType, selectedDateTime) {
                if (confirm('本当に退社時間を記録しますか?')) {
                    submitForm(recordType, selectedDateTime);
                }
            }

            function submitForm(recordType, selectedDateTime) {
                buttonValueInput.value = recordType;
                dateInput.value = selectedDateTime;

                let route;
                switch (recordType) {
                    case 'StartBreak':
                        route = '{{ route('time.start.break') }}';
                        break;
                    case 'EndBreak':
                        route = '{{ route('time.end.break') }}';
                        break;
                    default:
                        route = '{{ route('time.record.manual') }}';
                }

                form.action = route;
                form.method = 'POST';
                form.submit();
            }
        });
    </script>

</x-app-layout>

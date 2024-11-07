<!-- Loop through each day of the previous month -->



@php
    // At the start of your blade template
    $holidayDates = $holidays->pluck('vacation_date')
        ->map(function($date) {
            return $date->format('Y-m-d');
        })
        ->toArray();
    // dump($holidayDates); // Should now show ["2024-11-06"]
@endphp


<style>
    .custom-select {
        background-image: none;
        /* Hide the default arrow */
    }
</style>

@php

    $statusTranslations = [
        'pending' => '申請中',
        'approved' => '承認済み',
        'denied' => '拒否済み',
    ];

    //color

    $statusColors = [
        'pending' => 'bg-gray-300',
        'approved' => 'bg-green-200',
        'denied' => 'bg-rose-300',
    ];

@endphp

@php

    $currentDate = Carbon\Carbon::now();

    $previousMonthStart = $startDate;
    $currentMonthStart = $endDate;
    $daysInPreviousMonth = $previousMonthStart->daysInMonth;
    $totalMinutesForMonth = 0; // Initialize total hours for the month
@endphp

@for ($i = 0; $i < $daysInPreviousMonth; $i++)
    @php
        $day = $previousMonthStart->copy()->addDays($i);
        $day->setLocale('ja');

        $startOfDay = $day->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = $day->endOfDay()->format('Y-m-d H:i:s');
        $isHoliday = in_array($day->format('Y-m-d'), $holidayDates);
        // dd($isHoliday);
    @endphp


    {{-- Your code here --}}
    <tr
        class="hover:bg-stone-200 transition-colors duration-300 ease-in-out
 @if ($day->isSunday()) bg-red-50
 @elseif ($day->isSaturday()) bg-sky-50
 @else bg-slate-50 @endif
 border-b border-gray-200">



        <td
            class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm font-medium text-gray-700">
            {{ $day->format('m') . '/' . $day->format('d') }}
            <br>
            <span class="text-xs text-gray-500">
                ({{ $day->isoFormat('dd') }})

            </span>

        </td>



        <!-- user modeloos kubun duudaaj tuhain hereglegchiin medeeleliig end gargah
            Responsive iin ynzlah
            -->

        <td
            class="px-1 sm:px-2 md:px-4 py-2 sm:py-3 border-r border-gray-300 shadow-sm text-xs sm:text-sm font-semibold">
            @php
                $timeOffRecordForDay = $user->timeOffRequestRecords->where('date', $day->format('Y-m-d'))->first();
            @endphp

            @if ($timeOffRecordForDay)
                @php
                    $bgColor = $statusColors[$timeOffRecordForDay->status] ?? '';
                @endphp
                <div class="rounded-full py-1 px-1 sm:px-2 {{ $bgColor }} text-center">
                    <div class="truncate">
                        {{ $timeOffRecordForDay->attendanceTypeRecord->name }}
                    </div>
                    <div class="truncate text-xs font-semibold">
                        {{ $statusTranslations[$timeOffRecordForDay->status] ?? $timeOffRecordForDay->status }}
                    </div>
                </div>

                @if (!in_array($timeOffRecordForDay->status, ['approved', 'denied']))
                    <button
                        onclick="openEditModal('{{ $timeOffRecordForDay->id }}', '{{ $day->format('Y-m-d') }}', '{{ $timeOffRecordForDay->attendance_type_records_id }}', '{{ $timeOffRecordForDay->reason_select }}', '{{ $timeOffRecordForDay->reason }}', '{{ $timeOffRecordForDay->boss_id }}')"
                        class="text-blue-500 hover:underline text-m font-semibold mt-1 block w-full text-center">
                        編集
                    </button>
                @endif
            @elseif ($isHoliday)
                <span
                    class="bg-yellow-100 text-yellow-700 px-1 sm:px-2 py-1 text-xs font-semibold rounded-full block text-center">公休</span>
            @else
                <button onclick="openModal('{{ $day->format('Y-m-d') }}')"
                    class="text-blue-500 hover:underline text-m block w-full text-center font-semibold">
                    申請
                </button>
            @endif


        </td>




        <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm text-yellow-600">

            @if (isset($breaks[$day->format('Y-m-d')]))
                @php

                    $breakMinutes = $breaks[$day->format('Y-m-d')]; // Total minutes for the day
                    $hours = floor($breakMinutes / 60); // Convert to hours
                    $minutes = $breakMinutes % 60; // Remaining minutes

                    echo sprintf('%02d:%02d', $hours, $minutes); // Display as HH:MM format
                @endphp
            @endif
        </td>





        {{-- <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
            <!-- Display arrival time for the day -->
            @php
                $arrival = $user
                    ->userArrivalRecords()
                    ->whereBetween('recorded_at', [$startOfDay, $endOfDay])
                    ->first();

                $arrivalTime = $arrival
                    ? Carbon\Carbon::parse($arrival->recorded_at)->setTimezone(config('app.timezone'))
                    : null;
                $departureTime =
                    $arrival && $arrival->arrivalDepartureRecords->count()
                        ? Carbon\Carbon::parse($arrival->arrivalDepartureRecords->first()->recorded_at)->setTimezone(
                            config('app.timezone'),
                        )
                        : null;

                if ($arrivalTime && $departureTime) {
                    $result = workTimeCalc($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                } else {
                    $result = null;
                }
                // dd($arrival);

                echo $arrivalTime ? $arrivalTime->format('H:i') : '';
                // {{ $departureTime ? $departureTime->format('H:i') : '' }};
                // dd($arrival,$departureTime, $arrivalTime);
            @endphp



        </td> --}}

        <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
            @php
                $arrival = $user
                    ->userArrivalRecords()
                    ->whereBetween('recorded_at', [$startOfDay, $endOfDay])
                    ->first();

                $arrivalTime = $arrival
                    ? Carbon\Carbon::parse($arrival->recorded_at)->setTimezone(config('app.timezone'))
                    : null;
                $departureTime =
                    $arrival && $arrival->arrivalDepartureRecords->count()
                        ? Carbon\Carbon::parse($arrival->arrivalDepartureRecords->first()->recorded_at)->setTimezone(
                            config('app.timezone'),
                        )
                        : null;

                if ($arrivalTime && $departureTime) {
                    $result = workTimeCalc($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                } else {
                    $result = null;
                }
            @endphp


            {{ $arrivalTime ? $arrivalTime->format('H:i') : '' }}



            @if($arrival)
                <form action="{{ route('timerecord.destroy', $arrival->id) }}"
                      method="POST"
                      class="inline-block mt-1"
                      onsubmit="return confirm('この記録を削除してもよろしいですか？\n関連する退社記録も削除されます。');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-400 px-1 py-1 rounded-lg hover:bg-red-500 transition-colors text-white font-semibold">
                        削除
                    </button>
                </form>
            @endif
        </td>


        <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
            <!-- Display departure time for the day -->
            @if ($arrival && $arrival->arrivalDepartureRecords->count() > 0)
                {{ \Carbon\Carbon::parse($arrival->arrivalDepartureRecords->first()->recorded_at)->format('H:i') }}
            @endif

            @php
                // dd($arrival->arrivalDepartureRecords);
            @endphp
        </td>

        @if (auth()->user()->office && auth()->user()->office->corp && auth()->user()->office->corp->corp_name === 'ユメヤ')
            <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
                @php
                    $arrivalSecond = $user
                        ->userArrivalRecords()
                        ->whereBetween('second_recorded_at', [$startOfDay, $endOfDay])
                        ->first();

                    $arrivalSecondTime = $arrivalSecond
                        ? Carbon\Carbon::parse($arrivalSecond->second_recorded_at)->setTimezone(config('app.timezone'))
                        : null;
                    $departureSecondTime =
                        $arrivalSecond && $arrivalSecond->arrivalDepartureRecords->count()
                            ? Carbon\Carbon::parse(
                                $arrivalSecond->arrivalDepartureRecords->first()->second_recorded_at,
                            )->setTimezone(config('app.timezone'))
                            : null;

                    if ($arrivalSecondTime && $departureSecondTime) {
                        $result = workTimeCalc($arrivalSecondTime->format('H:i'), $departureSecondTime->format('H:i'));
                    } else {
                        $result = null;
                    }
                    // dd($arrivalSecond);

                    echo $arrivalSecondTime ? $arrivalSecondTime->format('H:i') : '';
                    // {{ $departureSecondTime ? $departureSecondTime->format('H:i') : '' }};
                    // dd($arrivalSecond,$departureSecondTime, $arrivalSecondTime);
                @endphp
            </td>


            <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
                @if ($arrivalSecond && $arrivalSecond->arrivalDepartureRecords->count() > 0)
                    @if ($arrivalSecond->arrivalDepartureRecords->first()->second_recorded_at != null)
                        {{ \Carbon\Carbon::parse($arrivalSecond->arrivalDepartureRecords->first()->second_recorded_at)->format('H:i') }}
                    @endif
                @endif
            </td>
        @endif



<!--real time calculation-->
        {{-- <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">



            @php
                // Define constants for the workday, break, and lunch times
                $regularStartTime = strtotime('08:30');
                $breakStartTime1 = strtotime('11:00');
                $breakEndTime1 = strtotime('11:10');
                $lunchStartTime = strtotime('12:00');
                $lunchEndTime = strtotime('13:00');
                $breakStartTime2 = strtotime('13:00');
                $breakEndTime2 = strtotime('13:10');
                $breakStartTime3 = strtotime('17:30'); // Add the new break start time
                $breakEndTime3 = strtotime('17:40'); // Add the new break end time
                $regularEndTime = strtotime('17:30');

                // Initialize total worked minutes for the day
                $totalWorkedMinutes = 0;

                // Calculate worked time if $arrivalTime and $departureTime are provided
                if ($arrivalTime && $departureTime) {
                    $workedStartTime = strtotime($arrivalTime->format('H:i'));
                    $workedEndTime = strtotime($departureTime->format('H:i'));

                    // Calculate worked time before lunch break
                    $beforeLunchWorkedTime = min($lunchStartTime, $workedEndTime) - $workedStartTime;
                    $totalWorkedMinutes += $beforeLunchWorkedTime / 60;

                    // Subtract first break time if applicable
                    if ($workedStartTime < $breakStartTime1 && $workedEndTime >= $breakEndTime1) {
                        $totalWorkedMinutes -= 10;
                    }

                    // Calculate worked time after lunch break
                    $afterLunchWorkedTime = max(0, $workedEndTime - max($workedStartTime, $lunchEndTime));
                    $totalWorkedMinutes += $afterLunchWorkedTime / 60;

                    // Subtract second break time if applicable
                    if ($workedStartTime < $breakStartTime2 && $workedEndTime >= $breakEndTime2) {
                        $totalWorkedMinutes -= 10;
                    }

                    // Subtract the new break time if applicable
                    if ($workedStartTime < $breakStartTime3 && $workedEndTime >= $breakEndTime3) {
                        $totalWorkedMinutes -= 10;
                    }

                    // end variable zarlaad shalgaad niit ajilsan miniutaas hasaj baina
                    $actualBreakMinutes = isset($breaks[$day->format('Y-m-d')]) ? $breaks[$day->format('Y-m-d')] : 0;
                    $totalWorkedMinutes -= $actualBreakMinutes;

                    // Ensure total worked minutes doesn't go negative
                    $totalWorkedMinutes = max(0, $totalWorkedMinutes);

                    if (
                        auth()->user()->office &&
                        auth()->user()->office->corp &&
                        auth()->user()->office->corp->corp_name === 'ユメヤ'
                    ) {
                        if ($arrivalSecondTime && $departureSecondTime) {
                            $workedSecondStartTime = strtotime($arrivalSecondTime->format('H:i'));
                            $workedSecondEndTime = strtotime($departureSecondTime->format('H:i'));
                            if ($workedSecondEndTime - $workedSecondStartTime > 0) {
                                $secondTotalWorkedMinutes = ($workedSecondEndTime - $workedSecondStartTime) / 60;
                                $totalWorkedMinutes += $secondTotalWorkedMinutes;
                            }
                        }
                    }

                                // Print formatted total worked time for the day
                                echo sprintf('%02d:%02d', floor($totalWorkedMinutes / 60), $totalWorkedMinutes % 60);
                            } else {
                                echo '';
                                            }
                            @endphp
        </td> --}}

<!--new time calculation-->


<td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
    @php
        // Check if user is from Yumeya
        $isYumeya = auth()->user()->office &&
                    auth()->user()->office->corp &&
                    auth()->user()->office->corp->corp_name === 'ユメヤ';

        $totalWorkedMinutes = 0;

        if ($isYumeya) {
            // Yumeya specific times
            $regularStartTime = strtotime('09:00');  // Different start time for Yumeya
            $breakStartTime1 = strtotime('00:00');   // Different break times
            $breakEndTime1 = strtotime('00:00');
            $lunchStartTime = strtotime('12:00');    // Different lunch time
            $lunchEndTime = strtotime('13:00');
            $breakStartTime2 = strtotime('00:00');
            $breakEndTime2 = strtotime('00:00');
            $regularEndTime = strtotime('18:00');    // Different end time

            if ($arrivalTime && $departureTime) {
                $workedStartTime = strtotime($arrivalTime->format('H:i'));
                $workedEndTime = strtotime($departureTime->format('H:i'));

                // Calculate first period with Yumeya's break schedule
                $beforeLunchWorkedTime = min($lunchStartTime, $workedEndTime) - $workedStartTime;
                $totalWorkedMinutes += $beforeLunchWorkedTime / 60;

                if ($workedStartTime < $breakStartTime1 && $workedEndTime >= $breakEndTime1) {
                    $totalWorkedMinutes -= 10;
                }

                $afterLunchWorkedTime = max(0, $workedEndTime - max($workedStartTime, $lunchEndTime));
                $totalWorkedMinutes += $afterLunchWorkedTime / 60;

                if ($workedStartTime < $breakStartTime2 && $workedEndTime >= $breakEndTime2) {
                    $totalWorkedMinutes -= 10;
                }

                // Add second period calculation for Yumeya
                if ($arrivalSecondTime && $departureSecondTime) {
                    $workedSecondStartTime = strtotime($arrivalSecondTime->format('H:i'));
                    $workedSecondEndTime = strtotime($departureSecondTime->format('H:i'));
                    if ($workedSecondEndTime - $workedSecondStartTime > 0) {
                        $secondTotalWorkedMinutes = ($workedSecondEndTime - $workedSecondStartTime) / 60;
                        $totalWorkedMinutes += $secondTotalWorkedMinutes;
                    }
                }
            }
        } else {
            // Original calculation for other companies
            $regularStartTime = strtotime('08:30');
            $breakStartTime1 = strtotime('11:00');
            $breakEndTime1 = strtotime('11:10');
            $lunchStartTime = strtotime('12:00');
            $lunchEndTime = strtotime('13:00');
            $breakStartTime2 = strtotime('13:00');
            $breakEndTime2 = strtotime('13:10');
            $breakStartTime3 = strtotime('17:30');
            $breakEndTime3 = strtotime('17:40');
            $regularEndTime = strtotime('17:30');

            if ($arrivalTime && $departureTime) {
                $workedStartTime = strtotime($arrivalTime->format('H:i'));
                $workedEndTime = strtotime($departureTime->format('H:i'));

                $beforeLunchWorkedTime = min($lunchStartTime, $workedEndTime) - $workedStartTime;
                $totalWorkedMinutes += $beforeLunchWorkedTime / 60;

                if ($workedStartTime < $breakStartTime1 && $workedEndTime >= $breakEndTime1) {
                    $totalWorkedMinutes -= 10;
                }

                $afterLunchWorkedTime = max(0, $workedEndTime - max($workedStartTime, $lunchEndTime));
                $totalWorkedMinutes += $afterLunchWorkedTime / 60;

                if ($workedStartTime < $breakStartTime2 && $workedEndTime >= $breakEndTime2) {
                    $totalWorkedMinutes -= 10;
                }

                if ($workedStartTime < $breakStartTime3 && $workedEndTime >= $breakEndTime3) {
                    $totalWorkedMinutes -= 10;
                }
            }
        }

        // Common calculations for both
        if ($arrivalTime && $departureTime) {
            // Subtract additional recorded breaks
            $actualBreakMinutes = isset($breaks[$day->format('Y-m-d')]) ? $breaks[$day->format('Y-m-d')] : 0;
            $totalWorkedMinutes -= $actualBreakMinutes;

            // Ensure total worked minutes doesn't go negative
            $totalWorkedMinutes = max(0, $totalWorkedMinutes);

            // Print formatted total worked time
            echo sprintf('%02d:%02d', floor($totalWorkedMinutes / 60), $totalWorkedMinutes % 60);
        } else {
            echo '';
        }
    @endphp
</td>






        {{-- <td class="px-6 py-4 whitespace-nowrap border border-gray-800">
            <!-- Calculate and display total hours worked for the day -->
            @php
                if ($result) {
                    $arrayWorkedMinutes = explode(':', $result['workedTime']);
                    $totalMinutesForMonth += $arrayWorkedMinutes[0] * 60 + $arrayWorkedMinutes[1];

                    // Format the time as H:i
                    echo sprintf('%02d:%02d', $arrayWorkedMinutes[0], $arrayWorkedMinutes[1]);
                } else {
                    echo '';
                }
            @endphp
        </td> --}}
        {{-- <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
            <!-- Calculate and display total hours overtime1 for the day -->
            @php
                if ($result) {
                    $arrayOverTime1 = explode(':', $result['overTime1']);
                    $totalMinutesForMonth += $arrayOverTime1[0] * 60 + $arrayOverTime1[1];

                    // Format the time as H:i
                    echo sprintf('%02d:%02d', $arrayOverTime1[0], $arrayOverTime1[1]);
                } else {
                    echo '';
                }
            @endphp
        </td>


        <td
            class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm hidden md:table-cell">
            <!-- Calculate and display total hours overtime2 for the day -->
            @php
                if ($result) {
                    $arrayOverTime2 = explode(':', $result['overTime2']);
                    $totalMinutesForMonth += $arrayOverTime2[0] * 60 + $arrayOverTime2[1];

                    // Format the time as H:i
                    echo sprintf('%02d:%02d', $arrayOverTime2[0], $arrayOverTime2[1]);
                } else {
                    echo '';
                }
            @endphp
        </td> --}}

        <!-- Overtime 1 TD -->

        <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm">
            @php
                $isYumeya = auth()->user()->office &&
                            auth()->user()->office->corp &&
                            auth()->user()->office->corp->corp_name === 'ユメヤ';

                if ($arrivalTime && $departureTime) {
                    if ($isYumeya) {
                        // Calculate Yumeya time
                        $result2 = workTimeCalcYumeya($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                        $arrayOverTime1 = explode(':', $result2['overTime1']);
                    } else {
                        // Calculate regular time
                        $result = workTimeCalc($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                        $arrayOverTime1 = explode(':', $result['overTime1']);
                    }

                    $totalMinutesForMonth += $arrayOverTime1[0] * 60 + $arrayOverTime1[1];
                    echo sprintf('%02d:%02d', $arrayOverTime1[0], $arrayOverTime1[1]);
                } else {
                    echo '';
                }
            @endphp
        </td>

        <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-300 shadow-sm text-sm hidden md:table-cell">
            @php
                if ($arrivalTime && $departureTime) {
                    if ($isYumeya) {
                        // Calculate Yumeya time
                        $result2 = workTimeCalcYumeya($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                        $arrayOverTime2 = explode(':', $result2['overTime2']);
                    } else {
                        // Calculate regular time
                        $result = workTimeCalc($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                        $arrayOverTime2 = explode(':', $result['overTime2']);
                    }

                    $totalMinutesForMonth += $arrayOverTime2[0] * 60 + $arrayOverTime2[1];
                    echo sprintf('%02d:%02d', $arrayOverTime2[0], $arrayOverTime2[1]);
                } else {
                    echo '';
                }
            @endphp
        </td>

        <!--nemeh-->
    </tr>

@endfor
<!-- Modal -->
<div id="attendanceModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg w-1/2 p-4">
        <h2 class="text-lg font-bold mb-4 text-center">申請</h2>

        <form id="attendanceForm" action="{{ route('admin.time_off.store') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="date" id="modalDate" value="">



            <div class="mt-4">

                <label for="attendance_type_records_id" class="block mb-2">区分選択</label>
                <select name="attendance_type_records_id" id="attendance_type_records_id"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">選択</option>
                    @foreach ($attendanceTypeRecords as $record)
                        <option value="{{ $record->id }}">{{ $record->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">

                <label for="reason_select" class="block mb-2">理由選択</label>
                <select name="reason_select" id="reason_select"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">選択</option>
                    <option value="私用の為">私用為</option>
                    <option value="通院の為">通院為</option>
                    <option value="計画有給休暇消化の為">計画有給休暇消化の為</option>
                    <option value="体調不良の為">体調不良の為</option>

                </select>

            </div>

            <div class="mt-4">
                <input type="text" name="reason" id="reason"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="リストにない理由については入力して下さい">
            </div>

            <div class="space-y-2">
                <label for="boss_id" class="block text-sm font-medium text-gray-700">Select Boss</label>
                <select name="boss_id" id="boss_id"
                    class="block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    required>
                    <option value="">Select a boss</option>
                    @foreach ($bosses as $boss)
                        <option value="{{ $boss->id }}">{{ $boss->name }}</option>
                    @endforeach
                </select>
            </div>



            <div
                class="flex flex-col md:flex-row justify-between mt-5 items-center space-y-3 md:space-y-0 md:space-x-4 ">
                <x-button purpose="default" onclick="closeModal()">
                    キャンセル
                </x-button>

                <x-button purpose="search" type="submit">
                    保存
                </x-button>
            </div>
        </form>
    </div>
</div>


<!-- Add Edit Modal -->
<div id="editAttendanceModal"
    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg w-1/2 p-4">
        <h2 class="text-lg font-bold mb-4 text-center">編集申請</h2>

        <form id="editAttendanceForm" action="{{ route('admin.time_off.update', '') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="date" id="editModalDate" value="">
            <input type="hidden" name="id" id="editModalId" value="">

            <div class="mt-4">
                <label for="edit_attendance_type_records_id" class="block mb-2">区分選択</label>
                <select name="attendance_type_records_id" id="edit_attendance_type_records_id"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">選択</option>
                    @foreach ($attendanceTypeRecords as $record)
                        <option value="{{ $record->id }}">{{ $record->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <label for="edit_reason_select" class="block mb-2">理由選択</label>
                <select name="reason_select" id="edit_reason_select"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">選択</option>
                    <option value="私用の為">私用為</option>
                    <option value="通院の為">通院為</option>
                    <option value="計画有給休暇消化の為">計画有給休暇消化の為</option>
                    <option value="体調不良の為">体調不良の為</option>
                </select>
            </div>



            <div class="mt-4">
                <label for="edit_reason" class="block mb-2">理由</label>
                <input type="text" name="reason" id="edit_reason"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="理由を入力してください">
            </div>

            <div class="mt-4">
                <label for="edit_boss_id" class="block mb-2">上司選択</label>
                <select name="boss_id" id="edit_boss_id"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">選択</option>
                    @foreach ($bosses as $boss)
                        <option value="{{ $boss->id }}">{{ $boss->name }}</option>
                    @endforeach
                </select>
            </div>

            <div
                class="flex flex-col md:flex-row justify-between mt-5 items-center space-y-3 md:space-y-0 md:space-x-4 ">
                <x-button purpose="default" onclick="closeEditModal()">
                    キャンセル
                </x-button>

                <x-button purpose="delete" type="button" onclick="deleteTimeOff()">
                    削除
                </x-button>

                <x-button purpose="search" type="submit">
                    更新
                </x-button>
            </div>
        </form>
    </div>
</div>




<script>
    function openModal(date) {
        document.getElementById('modalDate').value = date;
        document.getElementById('attendanceModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('attendanceModal').classList.add('hidden');
    }

    function openEditModal(id, date, attendanceTypeId, reasonSelect, reason, bossId) {
        document.getElementById('editModalId').value = id;
        document.getElementById('editModalDate').value = date;
        document.getElementById('edit_attendance_type_records_id').value = attendanceTypeId;
        document.getElementById('edit_boss_id').value = bossId;

        // Set the selected value for reason_select
        const reasonSelectElement = document.getElementById('edit_reason_select');
        if (reasonSelectElement) {
            reasonSelectElement.value = reasonSelect || '';
        }

        // Set the value for reason input
        const reasonInput = document.getElementById('edit_reason');
        if (reasonInput) {
            reasonInput.value = reason || '';
        }

        document.getElementById('editAttendanceModal').classList.remove('hidden');

        // Update the form action URL
        const form = document.getElementById('editAttendanceForm');
        form.action = "{{ route('admin.time_off.update', '') }}/" + id;
    }

    function closeEditModal() {
        document.getElementById('editAttendanceModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Edit form submission
        const editForm = document.getElementById('editAttendanceForm');
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, 'POST'); // Using POST for Laravel's form method spoofing
        });

        function submitForm(form, method) {
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        closeEditModal();
                        window.location.reload();
                    } else {
                        alert(data.message || 'エラーが発生しました。もう一度お試しください。');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('エラーが発生しました。もう一度お試しください。');
                });
        }
    });

    function deleteTimeOff() {
        if (confirm('本当に削除しますか？')) {
            const id = document.getElementById('editModalId').value;
            const deleteUrl = "{{ route('admin.time_off.destroy', '') }}/" + id;

            fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        closeEditModal();
                        window.location.reload();
                    } else {
                        alert(data.message || 'エラーが発生しました。もう一度お試しください。');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('エラーが発生しました。もう一度お試しください。');
                });
        }
    }
</script>

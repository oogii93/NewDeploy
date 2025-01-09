<!-- Loop through each day of the previous month -->



@php

use App\Models\AttendanceTypeRecord;
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


@php
    $today = \Carbon\Carbon::today()->day;
@endphp

    <div class="flex justify-normal mb-2">

        <div class="flex flex-col items-center justify-center w-20 h-20 bg-gradient-to-br hover:text-white from-green-100 to-green-300 hover:from-green-400 hover:to-green-500 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-amber-200">

            {{-- @if($today >= 14 && $today <= 15) --}}




                <button id="validateMonthBtn"
                    class="text-sm font-semibold">


                    当月の勤怠確定処理
                </button>


            {{-- @endif --}}

        </div>




    </div>




<div id="validationResults" class="hidden space-y-4 mt-4 mb-4"></div>


@for ($i = 0; $i < $daysInPreviousMonth; $i++)
    @php
        $day = $previousMonthStart->copy()->addDays($i);
        $day->setLocale('ja');

        $startOfDay = $day->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = $day->endOfDay()->format('Y-m-d H:i:s');
        $isHoliday = in_array($day->format('Y-m-d'), $holidayDates);

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



        <td class="px-1 sm:px-2 md:px-4 py-2 sm:py-3 border-r border-gray-300 shadow-sm text-xs sm:text-sm font-semibold">
            @php
                $timeOffRecordForDay = $user->timeOffRequestRecords->where('date', $day->format('Y-m-d'))->first();
                $compensatoryRestDay = $user->timeOffRequestRecords
                    ->where('attendance_type_records_id', AttendanceTypeRecord::where('name', '休日出勤')->first()->id)
                    ->where('status', 'approved')
                    ->where('date2', $day->format('Y-m-d'))
                    ->first();
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

                @if (in_array($timeOffRecordForDay->status, ['approved','pending','denied']))
                    <button
                        onclick="openEditModal('{{ $timeOffRecordForDay->id }}', '{{ $day->format('Y-m-d') }}', '{{ $timeOffRecordForDay->attendance_type_records_id }}', '{{ $timeOffRecordForDay->reason_select }}', '{{ $timeOffRecordForDay->reason }}', '{{ $timeOffRecordForDay->boss_id }}')"
                        class="text-blue-500 hover:underline text-m font-semibold mt-1 block w-full text-center">
                        編集
                    </button>

                @endif

            @elseif ($compensatoryRestDay)
                <div class="rounded-full py-1 px-1 sm:px-2 bg-yellow-100 text-center">
                    <div class="truncate text-yellow-700">
                        振替休日
                    </div>
                    <div class="truncate text-xs font-semibold text-yellow-700">
                        承認済
                    </div>
                </div>
            @elseif ($isHoliday)
                <span class="bg-yellow-100 text-yellow-700 px-1 sm:px-2 py-1 text-xs font-semibold rounded-full block text-center">
                    公休
                </span>

                <button onclick="openModal2('{{ $day->format('Y-m-d') }}')"
                    class="bg-blue-400 hover:bg--600 rounded-full text-white text-xs hover:text-md font-semibold block w-full text-center mt-2 px-2 py-1">
                    休日出勤
                </button>
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
                    $breakMinutes = $breaks[$day->format('Y-m-d')];
                    $breakRecord = \App\Models\Breaks::where('user_id', $user->id)
                        ->whereDate('start_time', $day)
                        ->first();

                    // Only show time if we have both start and end time
                    if ($breakRecord && $breakRecord->start_time && $breakRecord->end_time) {
                        $hours = floor($breakMinutes / 60);
                        $minutes = $breakMinutes % 60;
                        echo sprintf('%02d:%02d', $hours, $minutes);
                    } else if ($breakRecord && $breakRecord->start_time) {
                        echo '休憩中';
                        echo '<br>';
                        echo '<span class="text-xs text-red-500">';
                        echo Carbon\Carbon::parse($breakRecord->start_time)->format('H:i');
                        echo '</span>';
                    }
                @endphp
            @endif
        </td>


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

            //yumeya
            $yumeyaMorningHalfDay=strtotime('04:00');



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
            $breakStartTime2 = strtotime('15:00');
            $breakEndTime2 = strtotime('15:10');
            $breakStartTime3 = strtotime('17:30');
            $breakEndTime3 = strtotime('17:40');
            $regularEndTime = strtotime('17:30');


            //nemelt
            $morninghalfday=strtotime('3:50');
            // dump($morninghalfday);

            if ($arrivalTime && $departureTime) {
                $workedStartTime = strtotime($arrivalTime->format('H:i'));
                $workedEndTime = strtotime($departureTime->format('H:i'));
                 // Check if it's a half day (12:30 departure)

                 if($departureTime->format('H:i') === '12:30'){
                    $totalWorkedMinutes=230; //3 hours 50 minutes
                 }else if($arrivalTime->format('H:i') === '13:30'){
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

                 }else{


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
                        $arrayOverTime2=explode(':', $result2['overTime2']);  //change string -iig into ','-array ,':'- tsagruu geh met,

                    } else {
                        // Calculate regular time
                        $result = workTimeCalc($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                        $arrayOverTime1 = explode(':', $result['overTime1']);
                        $arrayOverTime2=explode(':', $result['overTime2']);
                    }

                    $totalMinutes=($arrayOverTime1[0]*60 + $arrayOverTime1[1] )+ ($arrayOverTime2[0]*60 +$arrayOverTime2[1] );


                    $hours=floor($totalMinutes /60);
                    $minutes=$totalMinutes %60;



                    // echo sprintf('%02d:%02d', $arrayOverTime1[0], $arrayOverTime1[1]);
                    echo sprintf('%02d:%02d', $hours, $minutes);
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

<div id="attendanceModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg w-4/5 md:w-1/2 p-6">
      <div class="flex items-center justify-between mb-4">
        <svg
        class="w-16 h-16"
        version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#14b8a6"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">  .st0{fill:#14b8a6;}  </style> <g> <path class="st0" d="M208.971,443.563c2.203-2.219,3.281-5.109,3.234-8l8.047-8.031l65.25-14 c6.672-1.203,12.266-5.719,14.859-11.984c0,0,12.375-27.641,19.891-40.172l-20.781-20.781l-3.234-3.25l-20.797-20.797 c-12.531,7.516-40.188,19.891-40.188,19.891c-6.266,2.594-10.766,8.188-11.969,14.844l-14.016,65.266l-8.016,8.031 c-2.906-0.016-5.813,1.047-8.016,3.25c-4.344,4.359-4.344,11.391,0,15.734S204.627,447.906,208.971,443.563z M256.564,363.063 c4.734-4.75,12.422-4.75,17.188,0c4.734,4.734,4.734,12.438,0,17.172c-4.766,4.734-12.453,4.734-17.188,0 C251.814,375.5,251.814,367.797,256.564,363.063z"></path> <path class="st0" d="M362.346,318.766l-44.313-44.328c0,0-15.531,15.531-20.531,20.531c-5.016,5-11.531,3.5-11.531,3.5l-6,6.031 l21.031,21.031l5.016,5l26.297,26.297l6-6.016c0,0-1.5-6.5,3.5-11.516C346.83,334.281,362.346,318.766,362.346,318.766z"></path> <path class="st0" d="M497.83,138.969c-20.5-20.484-42.844-18.625-66.141,4.656c-23.266,23.281-90.219,106.625-106,122.406 l45.078,45.063c15.766-15.766,99.109-82.719,122.391-106S518.314,159.453,497.83,138.969z M477.486,175.141l-70.156,70.141 c-1.719,1.734-4.484,1.734-6.203,0l-9.625-9.625c-1.703-1.688-1.703-4.469,0-6.188l70.141-70.156c1.719-1.719,4.516-1.719,6.234,0 l9.609,9.625C479.205,170.656,479.205,173.438,477.486,175.141z"></path> <rect x="88.408" y="201.844" class="st0" width="194.5" height="22.109"></rect> <rect x="88.408" y="279.219" class="st0" width="145.875" height="22.094"></rect> <rect x="88.408" y="356.563" class="st0" width="103.891" height="22.109"></rect> <path class="st0" d="M358.58,356.969l-8.063,6.656l-7.938,7.938v102.156H26.518V38.281h213.281v83.484 c0,5.906,2.438,11.359,6.313,15.203c3.859,3.875,9.297,6.313,15.219,6.313h81.25v76.5c4.297-5.125,8.813-10.469,13.391-15.922 c4.313-5.141,8.719-10.391,13.125-15.625v-72.578L265.221,11.766H11.049c-6.109,0-11.047,4.953-11.047,11.047v466.375 c0,6.094,4.938,11.047,11.047,11.047h347c6.109,0,11.047-4.953,11.047-11.047V337.031l-12.672,12.672L358.58,356.969z M261.924,45.969l75.188,75.203h-75.188V45.969z"></path> </g> </g></svg>
        <h2 class="text-2xl font-bold text-teal-500">申請書</h2>
        <button class="text-gray-500 hover:text-gray-700 focus:outline-none" onclick="closeModal()">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form id="attendanceForm" action="{{ route('admin.time_off.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="date" id="modalDate" value="">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="attendance_type_records_id" class="block mb-2 text-sm font-medium text-gray-700">区分選択</label>
            <select name="attendance_type_records_id" id="attendance_type_records_id" class="rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500 block w-full">
              <option value="">選択</option>
              @foreach ($attendanceTypeRecords as $record)
                @if ($record->name !=='休日出勤')
                  <option value="{{ $record->id }}">{{ $record->name }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div>
            <label for="reason_select" class="block mb-2 text-sm font-medium text-gray-700">理由選択</label>
            <select name="reason_select" id="reason_select" class="rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500 block w-full">
              <option value="">選択</option>
              <option value="私用の為">私用の為</option>
              <option value="通院の為">通院の為</option>
              <option value="計画有給休暇消化の為">計画有給休暇消化の為</option>
              <option value="体調不良の為">体調不良の為</option>
            </select>
          </div>
        </div>

        <div class="mt-4">
          <label for="reason" class="block mb-2 text-sm font-medium text-gray-700">リストにない理由</label>
          <input type="text" name="reason" id="reason" class="rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500 block w-full" placeholder="入力してください">
        </div>

        <div class="mt-4">
          <label for="boss_id" class="block mb-2 text-sm font-medium text-gray-700">上司を選択</label>
          <select name="boss_id" id="boss_id" class="rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500 block w-full" required>
            <option value="">選択してください。</option>
            @foreach ($bosses as $boss)
              <option value="{{ $boss->id }}">{{ $boss->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
          <x-button purpose="default" onclick="closeModal()" class="">
            キャンセル
          </x-button>

          <x-button purpose="search" type="submit" class="bg-teal-500 hover:bg-teal-600 text-white">
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
                        @if ($record->name !=='休日出勤')
                        <option value="{{ $record->id }}">{{ $record->name }}</option>
                        @elseif ($record->name ==='休日出勤')
                        <option value="{{ $record->id }}">{{ $record->name }}</option>

                        @endif
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


<!-- Modal Holiday Work-->
<div id="holidayModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg w-1/2 p-4">
        <h2 class="text-lg font-bold mb-4 text-center">休日出勤申請書</h2>
<!-- Change this line in your second modal -->
<form id="holidayForm" action="{{ route('admin.time_off.store2') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="date" id="modalDate2" value="">



            <div class="mt-4">
                <select name="attendance_type_records_id" id="attendance_type_records_id"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @foreach ($attendanceTypeRecords as $record)
                        @if ($record->name === '休日出勤')
                            <option value="{{ $record->id }}" selected>{{ $record->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mt-4">

                <label for="reason" class="block mb-2">理由</label>
                <input type="text" name="reason" id="reason"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="理由については入力して下さい">


            </div>

            <div class="mt-4">

                <label for="date2" class="block mb-2">変わりに休む日</label>
                <input type="date" name="date2" id="date2"
                    class="rounded block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="理由については入力して下さい">


            </div>



            <div class="space-y-2">
                <label for="boss_id" class="block text-sm font-medium text-gray-700 mt-2">申請するために上司を選択してください。</label>
                <select name="boss_id" id="boss_id"
                    class="block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    required>
                    <option value="">上司を選択</option>
                    @foreach ($bosses as $boss)
                        <option value="{{ $boss->id }}">{{ $boss->name }}</option>
                    @endforeach
                </select>
            </div>



            <div
                class="flex flex-col md:flex-row justify-between mt-5 items-center space-y-3 md:space-y-0 md:space-x-4 ">
                <x-button purpose="default" onclick="closeModal2()">
                    キャンセル
                </x-button>

                <x-button purpose="search" type="submit">
                    保存
                </x-button>
            </div>
        </form>
    </div>
</div>

<div id="editHolidayModal"
    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg w-1/2 p-4">
        <h2 class="text-lg font-bold mb-4 text-center">編集休日出勤申請書</h2>

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
                        @if ($record->name ==='休日出勤')
                        <option selected value="{{ $record->id }}">{{ $record->name }}</option>

                        @endif
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
    const holidayDates = @json($holidayDates);
</script>

<script>





 document.addEventListener('DOMContentLoaded', function() {
    // First modal form submission
    const attendanceForm = document.getElementById('attendanceForm');
    if (attendanceForm) {
        attendanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this);
        });
    }

    // Second modal form submission
    const holidayForm = document.getElementById('holidayForm');
    if (holidayForm) {
        holidayForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this);
        });
    }

    function submitForm(form) {
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(Object.values(err.errors).flat().join('\n'));
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
                if (form.id === 'attendanceForm') {
                    closeModal();
                } else {
                    closeModal2();
                }
                window.location.reload();
            } else {
                alert(data.message || 'エラーが発生しました。もう一度お試しください。');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'エラーが発生しました。もう一度お試しください。');
        });
    }
});

function openModal(date) {
    document.getElementById('modalDate').value = date;
    document.getElementById('attendanceModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('attendanceModal').classList.add('hidden');
}

function openModal2(date) {
    document.getElementById('modalDate2').value = date;  // Updated to use modalDate2
    document.getElementById('holidayModal').classList.remove('hidden');
}

function closeModal2() {
    document.getElementById('holidayModal').classList.add('hidden');
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

    function closeEditModal() {
        document.getElementById('editAttendanceModal').classList.add('hidden');
    }


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



    //ssasdsf


function openeditHolidayModal(id, date, attendanceTypeId,  reason, bossId) {
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

    function closeEditModal() {
        document.getElementById('editAttendanceModal').classList.add('hidden');
    }



    document.getElementById('validateMonthBtn').addEventListener('click', function() {
    const button = this;
    button.disabled = true;
    button.textContent = '検証中...';

    fetch(`/attendance/validate-period`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            holidayDates: holidayDates // Pass the holiday dates to the backend
        })
    })
    .then(response => response.json())
    .then(data => {
        const resultsDiv = document.getElementById('validationResults');
        resultsDiv.innerHTML = '';
        resultsDiv.classList.remove('hidden');

       // Common close button HTML
       const closeButton = `
            <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200"
                    onclick="this.closest('.validation-message').remove()">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>`;

        if (data.isValid) {
            resultsDiv.innerHTML = `
                <div class="validation-message relative bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm transition-all duration-300 ease-in-out">
                    ${closeButton}
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-green-800 font-medium">すべての記録が正しく入力されています</p>
                    </div>
                    <p class="text-green-700 text-sm mt-2">
                        検証期間: ${data.periodStart} から ${data.periodEnd}<br>
                        <span class="text-sm italic">※土日と指定された休日は検証対象外です</span>
                    </p>
                </div>`;
        } else {
            let issuesHtml = `
                <div class="validation-message relative bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-sm space-y-2 transition-all duration-300 ease-in-out">
                    ${closeButton}
                    <p class="text-gray-800 font-medium">
                        検証期間: ${data.periodStart} から ${data.periodEnd}<br>
                        <span class="text-sm italic">※土日と指定された休日は検証対象外です</span>
                    </p>`;

            if (data.issues && data.issues.length > 0) {
                issuesHtml += `
                    <div class="mt-3">
                        <p class="text-red-800 font-medium mb-2">以下の問題が見つかりました：</p>
                        <ul class="list-disc list-inside text-gray-700 space-y-1.5">`;

                data.issues.forEach(issue => {
                    issuesHtml += `<li class="flex items-start">
                        <span class="mr-2">•</span>
                        <span>${issue}</span>
                    </li>`;
                });

                issuesHtml += '</ul></div>';
            }

            issuesHtml += '</div>';

            if (data.warnings && data.warnings.length > 0) {
                issuesHtml += `
                    <div class="validation-message relative bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-sm space-y-2 mt-4 transition-all duration-300 ease-in-out">
                        ${closeButton}
                        <p class="text-yellow-800 font-medium mb-2">警告：</p>
                        <ul class="list-disc list-inside text-yellow-700 space-y-1.5">`;

                data.warnings.forEach(warning => {
                    issuesHtml += `<li class="flex items-start">
                        <span class="mr-2">•</span>
                        <span>${warning}</span>
                    </li>`;
                });

                issuesHtml += '</ul></div>';
            }

            resultsDiv.innerHTML = issuesHtml;
        }
    })
    .catch(error => {
        const resultsDiv = document.getElementById('validationResults');
        resultsDiv.innerHTML = `
            <div class="validation-message relative bg-red-50 border border-red-200 rounded-lg p-4 shadow-sm transition-all duration-300 ease-in-out">
                ${closeButton}
                <p class="text-red-800">エラーが発生しました。後でもう一度お試しください。</p>
            </div>`;
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = '当月の勤怠確定処理';
    });
});




</script>


<div class="w-full overflow-x-auto shadow-lg rounded-lg">
    <table class="w-full table-auto divide-y divide-gray-200 bg-sky-300">
        <!-- Company Info Header -->
        <thead class="">
                <th colspan="2" class="px-4 py-3 text-left border-r ">
                    <div class="flex flex-col">
                        <span class="text-gray-700 font-semibold text-sm md:text-base">{{ $user->corp->corp_name }}</span>
                        <span class="text-gray-600 text-xs md:text-sm">{{ $user->office->office_name }}</span>
                    </div>
                </th>
                <th colspan="2" class="px-4 py-3 text-left ">
                    <div class="flex flex-col">
                            社員氏名: {{ $user->name }}
                        <span class="text-gray-700 font-semibold text-sm md:text-base">
                        </span>
                        <span class="text-gray-600 text-xs md:text-sm">
                            社員番号: {{ $user->employer_id }}
                        </span>
                    </div>
                </th>

            <!-- Column Headers -->
            <tr class="bg-gray-50 border-t border-b border-gray-200">
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">日付け</span>
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">勤怠区分</span>
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">外出</span>
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">始業時刻</span>
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">終業時刻</span>
                </th>

                @if ($corpName === 'ユメヤ')
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                        <span class="block">二回出席</span>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                        <span class="block">二回退勤</span>
                    </th>
                @endif

                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">労働時間</span>
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">残業時間1</span>
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">残業時間2</span>
                </th>
            </tr>
        </thead>



            @php


    // At the start of your blade template
    $holidayDates = $holidays->pluck('vacation_date')
        ->map(function($date) {
            return $date->format('Y-m-d');
        })
        ->toArray();
        $currentDate = $startDate->copy();
        $totalMinutesForMonth = 0;
    // dump($holidayDates); // Should now show ["2024-11-06"]
@endphp


            @while ($currentDate <= $endDate)

            @php
            $dayOfWeek = $currentDate->dayOfWeek;
            $isHoliday = in_array($currentDate->format('Y-m-d'), $holidayDates);
            // dd($isHoliday);

            // Determine the day color based on the day of the week or if it's a holiday
          // Determine the day color based on the day of the week or if it's a holiday
          $dayColor = '';
            if ($dayOfWeek == 0) {
                $dayColor = 'bg-red-200';
            } elseif ($dayOfWeek == 6) {
                $dayColor = 'bg-sky-200';
            } elseif ($isHoliday) {
                $dayColor = 'bg-pink-100'; // Optional: different color for holidays if needed
            }
        @endphp

<tbody class="bg-white divide-y divide-gray-200">
    <tr class="transition-colors duration-300 ease-in-out {{ $dayColor }} hover:bg-gray-50">
                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $currentDate->format('m/d') }}</span>
                            <span class="ml-1 text-gray-500">({{ $currentDate->isoFormat('dd') }})</span>
                        </div>
                    </td>



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
                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            $timeOffRecordForDay = $user->timeOffRequestRecords->where('date', $currentDate->format('Y-m-d'))->first();
                        @endphp

                        @if ($timeOffRecordForDay)
                        <span class="bg-sky-500 rounded-lg text-white px-2 py-1">
                            {{ $timeOffRecordForDay->attendanceTypeRecord->name }}



                        </span>
                        {{-- <p class="mt-1 px-1 py-1 text-xs rounded-lg text-white font-semibold {{ $timeOffRecordForDay->status === 'approved' ? 'bg-green-500' : ($timeOffRecordForDay->status === 'pending' ? 'bg-yellow-400': 'bg-rose-300') }}"> --}}

                       <span class="text-xs px-2 font-gray-600 rounded-md text-white font-medium {{ $timeOffRecordForDay->status === 'approved' ? 'bg-green-500' : ($timeOffRecordForDay->status === 'pending' ? 'bg-yellow-400': 'bg-rose-300') }}">
                        {{ $statusTranslations[$timeOffRecordForDay->status] }}

                    </span>

                        {{-- </p> --}}
                        @elseif ($isHoliday)
                        <span class="text-white bg-orange-300 px-2 py-1 rounded-lg">公休</span>
                        @endif
                    </td>


                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            $breakMinutes = $breakData[$user->id][$currentDate->format('Y-m-d')] ?? null;
                        @endphp

                        @if ($breakMinutes)

                            @php
                                    $hours = floor($breakMinutes / 60);
                                    $minutes = $breakMinutes % 60;
                                    echo sprintf('%02d:%02d', $hours, $minutes);


                            @endphp
                        @else


                        @endif

                    </td>



                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            $arrivalRecord = $user->userArrivalRecords()
                                ->where('recorded_at', '>=', $currentDate->copy()->startOfDay())
                                ->where('recorded_at', '<=', $currentDate->copy()->endOfDay())
                                ->first();
                            if ($arrivalRecord) {
                                echo \Carbon\Carbon::parse($arrivalRecord->recorded_at)->format('H:i');
                            } else {
                                echo "";
                            }
                        @endphp
                    </td>

                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                echo \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at)->format('H:i');
                            }
                        @endphp
                    </td>
                    @if ($corpName === 'ユメヤ')
                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            $arrivalSecond = $user->userArrivalRecords()
                                ->where('second_recorded_at', '>=', $currentDate->copy()->startOfDay())
                                ->where('second_recorded_at', '<=', $currentDate->copy()->endOfDay())
                                ->first();

                            if ($arrivalSecond && $arrivalSecond->second_recorded_at) {
                                echo \Carbon\Carbon::parse($arrivalSecond->second_recorded_at)->format('H:i');
                            }
                        @endphp
                    </td>
                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            if ($arrivalSecond && $arrivalSecond->arrivalDepartureRecords->count() > 0) {
                                $departureSecond = $arrivalSecond->arrivalDepartureRecords->first()->second_recorded_at;
                                if ($departureSecond) {
                                    echo \Carbon\Carbon::parse($departureSecond)->format('H:i');
                                }
                            }
                        @endphp
                    </td>
                @endif




                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php

                        $totalWorkedMinutes=0;
                            // Define general constants for the workday, break, and lunch times
                            if ($corpName === 'ユメヤ') {
                                $regularStartTime = strtotime('09:00');
                                $breakStartTime1 = strtotime('00:00');
                                $breakEndTime1 = strtotime('00:00');
                                $lunchStartTime = strtotime('12:00');
                                $lunchEndTime = strtotime('13:00');
                                $breakStartTime2 = strtotime('00:00');
                                $breakEndTime2 = strtotime('00:00');
                                $regularEndTime = strtotime('18:00');
                            } else {
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

                                // half day nemelt
                                $morninghalfday=strtotime('3:50');


                            }


                            // Calculate worked time if $arrivalTime and $departureTime are provided
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                $arrivalTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at);
                                $departureTime = \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at);


                                if(!($corpName ==='ユメヤ')){
                                    if($departureTime->format('H:i') === '12:30'){
                                        $totalWorkedMinutes=230;
                                    }else if($arrivalTime->format('H:i') ==='13:30'){
                                        $workedStartTime=strtotime($arrivalTime->format('H:i'));
                                        $workedEndTime=strtotime($departureTime->format('H:i'));

                                        if($workedStartTime < $breakStartTime1 && $workedEndTime >= $breakEndTime1){
                                            $totalWorkedMinutes -= 10;
                                        }

                                        $afterLunchWorkedTime=max(0, $workedEndTime -max($workedStartTime, $lunchEndTime));
                                        $totalWorkedMinutes +=$afterLunchWorkedTime/60;

                                        if($workedStartTime < $breakStartTime2 && $workedEndTime >= $breakEndTime2){
                                            $totalWorkedMinutes-=10;
                                        }
                                        if ($workedStartTime < $breakStartTime3 && $workedEndTime >= $breakEndTime3) {
                                            $totalWorkedMinutes -= 10;
                                        }
                                    }else{
                                        //regular day calculation

                                        $workedStartTime=strtotime($arrivalTime->format('H:i'));
                                        $workedEndTime=strtotime($departureTime->format('H:i'));

                                        $beforeLunchWorkedTime=min($lunchStartTime, $workedEndTime)-$workedStartTime;
                                        $totalWorkedMinutes +=$beforeLunchWorkedTime/60;

                                        if($workedStartTime < $breakStartTime1 && $workedEndTime >= $breakEndTime1){
                                            $totalWorkedMinutes-=10;
                                        }

                                        $afterLunchWorkedTime=max(0, $workedEndTime -max($workedStartTime, $lunchEndTime));
                                        $totalWorkedMinutes+=$afterLunchWorkedTime/60;

                                        if($workedStartTime < $breakStartTime2 && $workedEndTime >= $breakEndTime2){
                                            $totalWorkedMinutes-=10;

                                        }
                                        if($workedStartTime < $breakStartTime3 && $workedEndTime >= $breakEndTime3){
                                            $totalWorkedMinutes -=10;
                                        }


                                    }


                                }
                                else{
                                         // Yumeya calculation
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
                                    }
                                    $breakMinutes=$breakData[$user->id][$currentDate->format('Y-m-d')] ?? 0;
                                    $totalWorkedMinutes-=$breakMinutes;

                                    $totalWorkedMinutes=max(0, $totalWorkedMinutes);

                                    echo sprintf('%02d:%02d', floor($totalWorkedMinutes/60), $totalWorkedMinutes % 60);
                            }
                        @endphp
                    </td>



                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                // Initialize times
                                $arrivalTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at);
                                $departureTime = \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at);

                                // Only proceed if both times are valid
                                if ($arrivalTime && $departureTime) {
                                    if ($corpName === 'ユメヤ') {
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
                                }
                            } else {
                                echo '';
                            }
                        @endphp
                    </td>

                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                // Initialize times
                                $arrivalTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at);
                                $departureTime = \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at);

                                // Only proceed if both times are valid
                                if ($arrivalTime && $departureTime) {
                                    if ($corpName === 'ユメヤ') {
                                        $result2 = workTimeCalcYumeya($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                                        $arrayOverTime2 = explode(':', $result2['overTime2']);
                                    } else {
                                        $result = workTimeCalc($arrivalTime->format('H:i'), $departureTime->format('H:i'));
                                        $arrayOverTime2 = explode(':', $result['overTime2']);
                                    }

                                    $totalMinutesForMonth += $arrayOverTime2[0] * 60 + $arrayOverTime2[1];
                                    echo sprintf('%02d:%02d', $arrayOverTime2[0], $arrayOverTime2[1]);
                                }
                            } else {
                                echo '';
                            }
                        @endphp
                    </td>
                </tr>
                @php
                    $currentDate->addDay();
                @endphp
            @endwhile
        </tbody>
    </table>
</div>

<!-- calendar-table.blade.php -->
<div class="table-container sm:inline-block sm:mr-3 mb-4">
    <table class="border-collapse sm:min-w-max">
        <thead>
            <tr class=" border border-gray-400">
                <th colspan="2" class="bg-sky-200 font-bold py-2 px-4"> {{ $user->corp->corp_name }}</th>
                <th colspan="2" class="bg-sky-200 font-bold py-2 px-4"> {{ $user->office->office_name }}</th>
                <th colspan="2" class="bg-sky-200 font-bold py-2 px-4">社員氏名: {{ $user->name }}</th>
                <th colspan="2" class="bg-sky-200 font-bold py-2 px-4">社員番号: {{ $user->employer_id }}</th>
            </tr>

            <tr>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">日付け</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">勤怠区分</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">外出</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">始業時刻</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">終業時刻</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">労働時間</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">残業時間1</th>
                <th class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">残業時間2</th>
            </tr>
        </thead>


        <tbody>

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
                $dayColor = 'bg-red-100';
            } elseif ($dayOfWeek == 6) {
                $dayColor = 'bg-blue-100';
            } elseif ($isHoliday) {
                $dayColor = 'bg-pink-100'; // Optional: different color for holidays if needed
            }
        @endphp

                <tr class="transition-colors duration-300 ease-in-out {{ $dayColor }}">
                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
                        {{ $currentDate->format('m/d') }} ({{ $currentDate->isoFormat('dd') }})
                    </td>




                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs text-blue-800">
                        @php
                            $timeOffRecordForDay = $user->timeOffRequestRecords->where('date', $currentDate->format('Y-m-d'))->first();
                        @endphp

                        @if ($timeOffRecordForDay)
                            {{ $timeOffRecordForDay->attendanceTypeRecord->name }}
                        @elseif ($isHoliday)
                        <span class="text-pink-500">公休</span>
                        @endif
                    </td>


                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs text-red-500">
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



                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
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

                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
                        @php
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                echo \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at)->format('H:i');
                            }
                        @endphp
                    </td>

                    {{-- <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
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
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                $arrivalTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at);
                                $departureTime = \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at);

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

                                // Print formatted total worked time for the day
                                echo sprintf('%02d:%02d', floor($totalWorkedMinutes / 60), $totalWorkedMinutes % 60);
                            }
                        @endphp
                    </td> --}}

                    {{-- <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
                        @php
                            // Define general constants for the workday, break, and lunch times
                            if ($corpName === 'ユメヤ') {
                                // Adjusted times for "ユメヤ"
                                $regularStartTime = strtotime('09:00');
                                $breakStartTime1 = strtotime('00:00');
                                $breakEndTime1 = strtotime('00:00');
                                $lunchStartTime = strtotime('12:00');
                                $lunchEndTime = strtotime('13:00');
                                $breakStartTime2 = strtotime('00:00');
                                $breakEndTime2 = strtotime('00:00');
                                $regularEndTime = strtotime('18:00');
                            } else {
                                // Default times
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
                            }

                            // Initialize total worked minutes for the day
                            $totalWorkedMinutes = 0;

                            // Calculate worked time if $arrivalTime and $departureTime are provided
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                $arrivalTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at);
                                $departureTime = \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at);

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
                                if (!isset($corpName) || $corpName !== 'ユメヤ') {
                                    if ($workedStartTime < $breakStartTime3 && $workedEndTime >= $breakEndTime3) {
                                        $totalWorkedMinutes -= 10;
                                    }
                                }

                                // Print formatted total worked time for the day
                                echo sprintf('%02d:%02d', floor($totalWorkedMinutes / 60), $totalWorkedMinutes % 60);
                            }
                        @endphp
                    </td> --}}
                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
                        @php
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
                                $breakStartTime2 = strtotime('13:00');
                                $breakEndTime2 = strtotime('13:10');
                                $breakStartTime3 = strtotime('17:30');
                                $breakEndTime3 = strtotime('17:40');
                                $regularEndTime = strtotime('17:30');
                            }

                            // Initialize total worked minutes for the day
                            $totalWorkedMinutes = 0;

                            // Calculate worked time if $arrivalTime and $departureTime are provided
                            if ($arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count() > 0) {
                                $arrivalTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at);
                                $departureTime = \Carbon\Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at);

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
                                if (!isset($corpName) || $corpName !== 'ユメヤ') {
                                    if ($workedStartTime < $breakStartTime3 && $workedEndTime >= $breakEndTime3) {
                                        $totalWorkedMinutes -= 10;
                                    }
                                }

                                // Subtract dynamic break minutes if they exist
                                $breakMinutes = $breakData[$user->id][$currentDate->format('Y-m-d')] ?? 0;
                                $totalWorkedMinutes -= $breakMinutes;

                                // Ensure total worked minutes don't go negative
                                $totalWorkedMinutes = max(0, $totalWorkedMinutes);

                                // Print formatted total worked time for the day
                                echo sprintf('%02d:%02d', floor($totalWorkedMinutes / 60), $totalWorkedMinutes % 60);
                            }
                        @endphp
                    </td>




                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
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

                    <td class="border border-gray-400 text-left py-2 px-4 uppercase font-semibold text-xs">
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

<div class="w-full overflow-x-auto shadow-lg rounded-lg">
    <table class="w-full table-auto divide-y divide-gray-200 bg-blue-200">
        <head>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <meta name="csrf-token" content="{{ csrf_token() }}">
        </head>
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
                <th class="px-4 py-3 text-left text-xs font-semibold bg-yellow-200 uppercase tracking-wider whitespace-nowrap">
                    <span class="block">支給チェック</span>
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




                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
                        @php
                            $timeOffRecordForDay = $user->timeOffRequestRecords->where('date', $currentDate->format('Y-m-d'))->first();
                        @endphp

                        @if ($timeOffRecordForDay)
                        <span class="bg-sky-500 rounded-lg text-white px-2 py-1">
                            {{ $timeOffRecordForDay->attendanceTypeRecord->name }}

                        </span>
                        @elseif ($isHoliday)
                        <span class="text-white bg-emerald-600 px-2 py-1 rounded-lg">公休</span>
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
                    <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300">
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

                    {{-- <td class="whitespace-nowrap px-2 py-2 text-xs sm:px-4 sm:py-3 sm:text-sm border border-gray-300"> --}}

                        <td class="{{ !$currentDate->isWeekend() ? 'bg-white' : 'flex justify-center py-4 bg-green-200' }} border-gray-600">
                            @php
                                $checkboxData = \App\Models\CheckboxData::where('user_id', $user->id)
                                    ->where('date', $currentDate->format('Y-m-d'))
                                    ->first();
                            @endphp

                            @if($currentDate->isWeekend())
                                @if($checkboxData && $checkboxData->is_checked)
                                    <span class="text-green-700 font-bold text-xs">チェックされました。</span>
                                    <button
                                        class="uncheck-btn text-red-500 hover:text-red-700 bg-red-100 w-8 h-8 flex items-center justify-center rounded-full font-bold text-md"
                                        data-user-id="{{ $user->id }}"
                                        data-date="{{ $currentDate->format('Y-m-d') }}"
                                        onclick="uncheckData(event)"
                                    >
                                        &#x2715; <!-- X symbol -->
                                    </button>
                                @else
                                    <input type="checkbox"
                                        class="checkbox-data"
                                        data-user-id="{{ $user->id }}"
                                        data-date="{{ $currentDate->format('Y-m-d') }}"
                                        onclick="saveCheckboxData(event)"
                                    >
                                @endif
                            @endif
                        </td>





                </tr>
                @php
                    $currentDate->addDay();
                @endphp
            @endwhile
        </tbody>
    </table>



    <script>
        function saveCheckboxData(event) {
            const checkbox = event.target;
            const userId = checkbox.dataset.userId;
            const date = checkbox.dataset.date;

            const tdRow = checkbox.closest('tr');

// Find the arrival and departure time cells
const arrivalTimeCell = tdRow.querySelector('td:nth-child(4)'); // Adjust index based on your table structure
const departureTimeCell = tdRow.querySelector('td:nth-child(5)'); // Adjust index based on your table structure

const arrivalTime = arrivalTimeCell ? arrivalTimeCell.textContent.trim() : null;
const departureTime = departureTimeCell ? departureTimeCell.textContent.trim() : null;



            $.ajax({
                type: 'POST',
                url: '{{ route("checkbox.save") }}',
                data: {
                    user_id: userId,
                    date: date,
                    is_checked: 1,
                    arrival_recorded_at:arrivalTime || null,
                    departure_recorded_at:departureTime || null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.message);

                    // Replace checkbox with "Stored" and uncheck button
                    const tdElement = checkbox.closest('td');
                    tdElement.innerHTML = `
                        <div class="flex items-center">
                            <span class="text-green-700 font-bold mr-2 text-xs">チェックされました。</span>
                            <button
                                class="uncheck-btn text-red-500 hover:text-red-700 text-xs font-bold bg-red-100 px-2 py-2 rounded-full"
                                data-user-id="${userId}"
                                data-date="${date}"
                                onclick="uncheckData(event)"
                            >
                                &#x2715;
                            </button>
                        </div>
                    `;
                },
                error: function(xhr, status, error) {
                    console.error('Error saving checkbox data:', xhr.responseJSON?.message || error);
                }
            });
        }

        function uncheckData(event) {
            const button = event.target.closest('.uncheck-btn');
            const userId = button.dataset.userId;
            const date = button.dataset.date;

            $.ajax({
                type: 'POST',
                url: '{{ route("checkbox.uncheck") }}',
                data: {
                    user_id: userId,
                    date: date,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.message);

                    // Replace "Stored" and uncheck button with checkbox
                    const tdElement = button.closest('td');
                    tdElement.innerHTML = `
                        <input type="checkbox"
                               class="checkbox-data"
                               data-user-id="${userId}"
                               data-date="${date}"
                               onclick="saveCheckboxData(event)"
                        >
                    `;
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting checkbox data:', xhr.responseJSON?.message || error);
                }
            });
        }
        </script>
</div>

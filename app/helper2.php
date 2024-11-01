

<?php

use Carbon\Carbon;

function workTimeCalcYumeya($startTime = '', $endTime = '')
{
    $result2 = [
        'workedTime' => '00:00:00',
        'countLate' => 0,
        'countEarly' => 0,
        'overTime1' => '00:00:00',
        'overTime2' => '00:00:00',
        'absentTime' => '00:00:00',
    ];

    if (empty($startTime) || empty($endTime)) {
        return $result2;
    }

    $sTime = Carbon::parse($startTime);
    $eTime = Carbon::parse($endTime);

    if ($eTime->lessThan($sTime)) {
        $eTime->addDay();
    }

    // Yumeya specific time ranges
    $timeRange1Start = Carbon::parse('09:00'); // Different start time for Yumeya
    $timeRange1End = Carbon::parse('12:00');
    $timeRange2Start = Carbon::parse('13:00');
    $timeRange2End = Carbon::parse('18:00'); // Different end time for Yumeya
    $timeRangeOver1Start = Carbon::parse('18:00'); // Different overtime start for Yumeya
    $timeRangeOver1End = Carbon::parse('22:00');
    $timeRangeOver2Start = Carbon::parse('22:00');
    $timeRangeOver2End = Carbon::parse('06:00')->addDay();

    $totalAbsentMinutes = 0;
    if ($eTime->greaterThan($timeRange2End)) {
        $normalDayEndTime = $timeRange2End;
    } else {
        $normalDayEndTime = $eTime;
        $result2['countEarly'] = 1;
        $totalAbsentMinutes += $eTime->diffInMinutes($timeRange2End);
    }

    if ($sTime->greaterThan($timeRange1Start)) {
        $result2['countLate'] = 1;
        $totalAbsentMinutes += $sTime->diffInMinutes($timeRange1Start);
    }

    $result2['absentTime'] = sprintf('%02d:%02d:00', floor($totalAbsentMinutes / 60), $totalAbsentMinutes %= 60);

    $totalMinutes = $sTime->diffInMinutes($normalDayEndTime);
    if ($totalMinutes > 240) {
        $totalMinutes -= 60; // Lunch break
    }

    $workedHours = floor($totalMinutes / 60);
    $workedMinutes = $totalMinutes % 60;
    $result2['workedTime'] = sprintf('%02d:%02d:00', $workedHours, $workedMinutes);

    // Calculate Overtime 1 (18:10 - 22:00)
    $totalOverMinutes1 = 0;
    if ($eTime->greaterThan($timeRangeOver1Start)) {
        $overE1Time = $eTime->greaterThan($timeRangeOver1End) ? $timeRangeOver1End : $eTime;
        $totalOverMinutes1 += $timeRangeOver1Start->diffInMinutes($overE1Time);
        $result2['overTime1'] = sprintf('%02d:%02d:00', floor($totalOverMinutes1 / 60), $totalOverMinutes1 %= 60);
    }

    // Calculate Overtime 2 (22:00 - 08:00)
    if ($eTime->greaterThan($timeRangeOver2Start)) {
        $overE2Time = $eTime->greaterThan($timeRangeOver2End) ? $timeRangeOver2End : $eTime;
        $totalOverMinutes2 = $timeRangeOver2Start->diffInMinutes($overE2Time);
        $result2['overTime2'] = sprintf('%02d:%02d:00', floor($totalOverMinutes2 / 60), $totalOverMinutes2 %= 60);
    }

    return $result2;
}

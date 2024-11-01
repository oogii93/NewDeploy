

<?php

use Carbon\Carbon;
use App\Models\Breaks;

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



function calculateValidMinutes($start, $end, $skipStart, $skipEnd)
{
    $duration = $start->diffInMinutes($end);

    if ($start < $skipEnd && $end > $skipStart) {
        $overlapStart = max($start, $skipStart);
        $overlapEnd = min($end, $skipEnd);
        $duration -= $overlapStart->diffInMinutes($overlapEnd);
    }

    return max(0, $duration); // Ensure no negative values
}

function calculateTotalBreakMinutes($userId, $startDate, $endDate)
{
    $totalMinutes = 0;

    $breaks = Breaks::where('user_id', $userId)
        ->whereBetween('start_time', [$startDate, $endDate])
        ->get()
        ->groupBy(function ($break) {
            return Carbon::parse($break->start_time)->format('Y-m-d');
        })
        ->map(function ($dayBreaks) {
            return $dayBreaks->sum(function ($break) {
                $totalMinutes = 0;
                $firstBreakDate = Carbon::parse($break->start_time);
                $skipStart = Carbon::createFromFormat('Y-m-d H:i', $firstBreakDate->format('Y-m-d') . ' 12:00');
                $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $firstBreakDate->format('Y-m-d') . ' 13:00');

                $firstStart = Carbon::parse($break->start_time);
                $firstEnd = Carbon::parse($break->end_time);
                $totalMinutes += calculateValidMinutes($firstStart, $firstEnd, $skipStart, $skipEnd);

                if (isset($break->start_time2) && isset($break->end_time2)) {
                    $secondStart = Carbon::parse($break->start_time2);
                    $secondEnd = Carbon::parse($break->end_time2);
                    $skipStart = Carbon::createFromFormat('Y-m-d H:i', $secondStart->format('Y-m-d') . ' 12:00');
                    $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $secondStart->format('Y-m-d') . ' 13:00');
                    $totalMinutes += calculateValidMinutes($secondStart, $secondEnd, $skipStart, $skipEnd);
                }

                if (isset($break->start_time3) && isset($break->end_time3)) {
                    $thirdStart = Carbon::parse($break->start_time3);
                    $thirdEnd = Carbon::parse($break->end_time3);
                    $skipStart = Carbon::createFromFormat('Y-m-d H:i', $thirdStart->format('Y-m-d') . ' 12:00');
                    $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $thirdStart->format('Y-m-d') . ' 13:00');
                    $totalMinutes += calculateValidMinutes($thirdStart, $thirdEnd, $skipStart, $skipEnd);
                }

                return $totalMinutes;
            });
        });

    return $breaks;
}


<?php

use Carbon\Carbon;


if (!function_exists('workTimeCalc')) {
function workTimeCalc($startTime = '', $endTime = '')
{
    $result = [



        'workedTime' => '00:00:00',
        'countLate' => 0,
        'countEarly' => 0,
        'overTime1' => '00:00:00',
        'overTime2' => '00:00:00',
        'absentTime'=>'00:00:00',

    ];

    $sTime = Carbon::parse($startTime);
    $eTime = Carbon::parse($endTime);

    if ($eTime->lessThan($sTime)) {

        $eTime->addDay();
    }

    $timeRange1Start = Carbon::parse('08:30');
    $timeRange1End = Carbon::parse('12:00');
    $timeRange2Start = Carbon::parse('13:00');
    $timeRange2End = Carbon::parse('17:30');
    $timeRangeOver1Start=Carbon::parse('17:40');
    $timeRangeOver1End=Carbon::parse('22:00');
    $timeRangeOver2Start=Carbon::parse('22:00');
    $timeRangeOver2End=Carbon::parse('07:30')->addDay();


    $totalAbsentMinutes=0;
    if ($eTime->greaterThan($timeRange2End)) {
        // Calculate the difference in hours between arrival and departure times
        $normalDayEndTime=$timeRange2End;

    }else{
        $normalDayEndTime=$eTime;
        $result['countEarly']=1;
        $totalAbsentMinutes+=$eTime->diffInMinutes($timeRange2End);

    }
    if ($sTime->greaterThan($timeRange1Start)){
        $result['countLate']=1;
        $totalAbsentMinutes+=$sTime->diffInMinutes($timeRange1Start);
    }
    $result['absentTime']=sprintf('%02d:%02d:00',floor($totalAbsentMinutes / 60),$totalAbsentMinutes%=60);


        $totalMinutes = $sTime->diffInMinutes($normalDayEndTime);//tsainii tsag hasaj tootsow
       if ($totalMinutes>240)
       {
        $totalMinutes-=60;
       }


            $adjustedMinutes=0;


        $workedMinutes = $totalMinutes - $adjustedMinutes;
        $workedHours = floor($workedMinutes / 60); // Extract the hours
        $workedMinutes %= 60; // Extract the remaining minutes

        $workedHoursFormatted =sprintf('%02d:%02d:00',$workedHours ,$workedMinutes);




        $result['workedTime'] = $workedHoursFormatted;
            $totalOverMinutes1=0;
        if($eTime->greaterThan($timeRangeOver1Start))
        {
            if($eTime->greaterThan($timeRangeOver1End))
            {
                $overE1Time=$timeRangeOver1End;
            }
            else
            {
                $overE1Time=$eTime;

            }
            $totalOverMinutes1+=$timeRangeOver1Start->diffInMinutes($overE1Time);

            // dd($totalOverMinutes1);

            $result['overTime1']=sprintf('%02d:%02d:00', floor($totalOverMinutes1 /60) ,$totalOverMinutes1%=60);
        }

        if($eTime->greaterThan($timeRangeOver2Start))
        {
            if($eTime->greaterThan($timeRangeOver2End))
            {
                $overE2Time=$timeRangeOver2End;
            }
            else
            {
                $overE2Time=$eTime;
            }
            $totalOverMinutes2=$timeRangeOver2Start->diffInMinutes($overE2Time);

            // dd($totalOverMinutes2);
            $result['overTime2']=sprintf('%02d:%02d:00', floor($totalOverMinutes2 /60) ,$totalOverMinutes2%=60);
        }





    return $result;
}
}



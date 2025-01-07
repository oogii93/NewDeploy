<?php


namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Corp;
use App\Models\User;
use App\Models\Breaks;
use App\Models\Office;
use League\Csv\Writer;
use App\Models\Calculation;
use App\Models\CheckboxData;
use Illuminate\Http\Request;
use App\Models\ArrivalRecord;
use App\Models\DepartureRecord;
use App\Models\VacationCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\CSV;
use Illuminate\Support\Facades\Log;
use App\Models\TimeOffRequestRecord;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Response as FileResponse;

class CSVController extends Controller
{

    //pisda
    // Add these functions to your existing controller/class:





private function parseExtendedTime($timeString)
{
    if (empty($timeString)) {
        return Carbon::createFromTime(0, 0, 0);
    }

    list($hours, $minutes, $seconds) = array_pad(explode(':', $timeString), 3, '0');
    $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

    return Carbon::createFromTime(0, 0, 0)->addSeconds($totalSeconds);
}

private function getTimeDifferenceInSeconds($time1, $time2)
{
    $seconds1 = $this->convertToSeconds($time1);
    $seconds2 = $this->convertToSeconds($time2);

    return abs($seconds1 - $seconds2);
}

private function convertToSeconds($timeString)
{
    if (empty($timeString)) {
        return 0;
    }

    list($hours, $minutes, $seconds) = array_pad(explode(':', $timeString), 3, '0');
    return ($hours * 3600) + ($minutes * 60) + $seconds;
}

// You already have this function
private function isValidTimeString($timeString)
{
    if (empty($timeString)) {
        return false;
    }

    return preg_match('/^\d{1,}:[0-5][0-9]:[0-5][0-9]$/', $timeString);
}



    public function formatSeconds3($seconds)
    {
        $hours=floor($seconds / 3600);
        $minutes=floor(($seconds % 3600) /60);
        $remainingSeconds=$seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
    }




    private function formatSeconds2($seconds)
    {
        $isNegative = false;
        if ($seconds < 0) {

            $isNegative = true;
            $seconds = abs($seconds); // Convert to positive value
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        if ($isNegative) {
            $formattedTime = '-' . $formattedTime; // Prepend the negative sign
        }

        return $formattedTime;
    }







    //amraltiin olgogdson udrvvdiig end VacationCalendar - aar duudaad ajiluulah
    protected function getHolidays($corpId, $officeId, $startDate, $endDate)
    {
        //oor gazar hiisen calculation end ashiglahdaa ehleed modeliin duudaj baina  jisheelbel vacationcalendar modeloor database-ees duddaaad
        return VacationCalendar::where('corp_id', $corpId)
            ->where('office_id', $officeId)
            ->whereBetween('vacation_date', [$startDate, $endDate])
            ->get();
    }




    // private function isValidTimeString($timeString)
    // {
    //     try {
    //         Carbon::parse($timeString);
    //         return true;
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }
    private function formatSeconds($seconds)
    {
        if (!is_numeric($seconds)) {

            return '00:00:00'; // Return a default value for non-numeric input
        }

        $isNegative = false;
        if ($seconds < 0) {
            $isNegative = true;
            $seconds = abs($seconds); // Convert to positive value
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        if ($isNegative) {
            $formattedTime = '-' . $formattedTime; // Prepend the negative sign
        }

        return $formattedTime;
    }


    //blade deer haruulah variable-uudaa duudaad blade rvv compact-aar ywuulj baina
    public function show(Request $request)
    {
        $corps = Corp::get();
        $offices = collect();
        $selectedCorpId = $request->input('corps_id');
        $calculations=$selectedCorpId ? Calculation::where('corp_id' , $selectedCorpId)->get() : collect();
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('n'));

        if ($selectedCorpId) {
            $offices = Office::where('corp_id', $selectedCorpId)->get();
        } else {
            $offices = Office::all();
        }

        // dd($request->all());

        return view('admin.calculated', compact('corps', 'offices', 'selectedCorpId', 'selectedYear', 'selectedMonth','calculations'));
    }









    protected function getCalculationValue($calculations, $key)
    {
      $calculations=$calculations->firstWhere('number', $key);

      return $calculations ? $calculations->tsag :null;
        // dump($calculations);
        //         dump(array_values($filteredValue));



    }





    //tsagnii bodoltuud ehelne


    protected function userTimeReportCollect($user, $startDate, $endDate, $workDayMinutes, $totalWorkDay, $totalWeekend, $month, $year,$corp_id, $calculations)
    {


        $calculations = Calculation::where('corps_id', $corp_id)->get();


        $workStartTimeConfig = $this->getCalculationValue($calculations, '1');//8:30
        $startOverTime = $this->getCalculationValue($calculations, '2');//17:40
        $endOverTime=$this->getCalculationValue($calculations, '3'); //06:00
        $morningOverTime=$this->getCalculationValue($calculations, '4'); //06:10

        $overTime2start=$this->getCalculationValue($calculations, '5'); //22:00
        $overTime2end=$this->getCalculationValue($calculations, '6');//06:00

        $workEndDay=$this->getCalculationValue($calculations, '7');//17:30

        $morning=$this->getCalculationValue($calculations, '8');//7:00








        $totalWorkedTime = 0;
        $totalWorkedDay = 0;
        $totalWorkedHoliday = 0;
        $countLate = 0;
        $earlyLeave = 0;
        $lateOverWorkAndFullWorkedTime = 0;
        $totalOverWorkedTimeA = 0;
        $totalOverWorkedTimeB = '00:00:00';
        $totalOverWorkedTimeC = '00:00:00';
        $totalOverWorkedTimeD = '00:00:00';
        //

        $countLateTime = 0;

        $lateArrivalSeconds = 0;
        $earlyLeaveHours=0;

        $breakTimeInSeconds=0;
        $allBreakTime=0;


        //endees shine umnuud nemne

        $checkedHoursSeconds = 0;
        $checkedHoursSeconds2 = 0;
        $excessHoursSeconds = 0;
        $excessHoursSeconds2 = 0;
        $shinyaWeekends = 0;
        $maxDailySeconds = 27600; // 7 hours 40 minutes in seconds

        $breakDeductionSeconds = 30 * 60;

        // Fetch CheckboxData for the given user and date range
        $checkboxData = CheckboxData::where('user_id', $user->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('arrival_recorded_at')
            ->whereNotNull('departure_recorded_at')
            ->get();

        foreach ($checkboxData as $data) {
            $arrivalTime = Carbon::parse($data->arrival_recorded_at);
            $departureTime = Carbon::parse($data->departure_recorded_at);


            $corp=$data->user->office->corp;
            $isYumeyaCorp=$corp->corp_name === 'ユメヤ';

            $maxDailySeconds=$isYumeyaCorp ? 28800 : 27600;

            // Calculate total time difference
            $timeDiffSeconds = $arrivalTime->diffInSeconds($departureTime);


            $breakSeconds=0;

            $lunchStartTime = Carbon::parse($arrivalTime->format('Y-m-d') . '12:00:00');
            $lunchEndTime = Carbon::parse($arrivalTime->format('Y-m-d') . '13:00:00');

            if ($arrivalTime <= $lunchEndTime && $departureTime >= $lunchStartTime) {
                $breakSeconds = 3600; // 1 hour lunch break for ALL
            }

            if(!$isYumeyaCorp){



                $break1Start=Carbon::parse($arrivalTime->format('Y-m-d') . '11:00:00');
                $break1End=Carbon::parse($arrivalTime->format('Y-m-d') . '11:10:00');


                if($arrivalTime <= $break1End && $departureTime >= $break1Start)
                {
                    $breakSeconds += 600;
                }

                    // Small break 3 (17:30-17:40)

                $break2Start=Carbon::parse($arrivalTime->format('Y-m-d') . '15:00:00');
                $break2End=Carbon::parse($arrivalTime->format('Y-m-d') . '15:10:00');


                if($arrivalTime <= $break2End && $departureTime >= $break2Start)
                {
                    $breakSeconds += 600;
                }
                    // Small break 3 (17:30-17:40)
                $break3Start = Carbon::parse($arrivalTime->format('Y-m-d') . ' 17:30:00');
                $break3End = Carbon::parse($arrivalTime->format('Y-m-d') . ' 17:40:00');

                if ($arrivalTime <= $break3End && $departureTime >= $break3Start) {
                    $breakSeconds += 600; // 10 minutes
                }




            }
            $timeDiffSeconds -=$breakSeconds;


            // if(!$isYumeyaCorp){
            //     $timeDiffSeconds -= $breakSeconds;
            // }





            // Create cutoff times
            $dailyLimitTime = Carbon::parse($arrivalTime->format('Y-m-d') . ' 22:00:00');


            // Saturday Logic
            if ($arrivalTime->isDayOfWeek(Carbon::SATURDAY)) {
                // If total work time exceeds daily limit (7:40)
                if ($timeDiffSeconds > $maxDailySeconds) {

                    $excessTime =$timeDiffSeconds - $maxDailySeconds;
                    //niit tsagaas - 7:40 abu-d ilvv tsag orj irne.



                    // Calculate how much time fits within daily limit



                    // Add time within limit
                    $checkedHoursSeconds += $maxDailySeconds;

                    // dd($abu,$checkedHoursSeconds,$timeDiffSeconds);

                    // Calculate late night hours (after 22:00)
                    if ($departureTime > $dailyLimitTime) {
                        // Calculate time between 22:00 and departure
                        $currentShinyaSeconds = $departureTime->diffInSeconds($dailyLimitTime);
                        $shinyaWeekends += $currentShinyaSeconds;

                        // Remaining time goes to excess
                        $excessHoursSeconds += $excessTime- $currentShinyaSeconds;
                    } else {
                        // If no work after 22:00, remaining time goes to excess
                        $excessHoursSeconds += $excessTime;
                    }
                } else {
                    // If total work time is within daily limit
                    $checkedHoursSeconds  += $timeDiffSeconds;
                }
            }
            elseif ($arrivalTime->isDayOfWeek(Carbon::SUNDAY)) {
                // If total work time exceeds daily limit (7:40)
                if ($timeDiffSeconds > $maxDailySeconds) {

                    $excessTime2 =$timeDiffSeconds - $maxDailySeconds;
                    //niit tsagaas - 7:40 abu-d ilvv tsag orj irne.



                    // Calculate how much time fits within daily limit


                    // Add time within limit
                    $checkedHoursSeconds2 += $maxDailySeconds;
                    // dd($checkedHoursSeconds,$maxDailySeconds);
                    // dd($abu,$checkedHoursSeconds,$timeDiffSeconds);

                    // Calculate late night hours (after 22:00)
                    if ($departureTime > $dailyLimitTime) {
                        // Calculate time between 22:00 and departure
                        $currentShinyaSeconds = $departureTime->diffInSeconds($dailyLimitTime);
                        $shinyaWeekends += $currentShinyaSeconds;

                        // Remaining time goes to excess
                        $excessHoursSeconds2 += $excessTime2  - $currentShinyaSeconds;
                    } else {
                        // If no work after 22:00, remaining time goes to excess
                        $excessHoursSeconds2 += $excessTime2;
                    }
                } else {
                    // If total work time is within daily limit
                    $checkedHoursSeconds2  += $timeDiffSeconds;
                }
            }



        }
    //     dd(   $checkedHoursSeconds,
    //     $checkedHours2Seconds,
    //     $excessHoursSeconds,
    //     $excess2HoursSeconds,
    //     $shinyaWeekends,
    // );








// huuchin shuud ajiladag baisan ni
        // $vacationRecords = $user->timeOffRequestRecords()
        //     ->whereDate('date', '>=', $startDate)
        //     ->whereDate('date', '<=', $endDate)
        //     ->get();





        $vacationRecords=$user->timeOffRequestRecords()
            ->where('status', 'approved')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->get();

        $vacationRecordsCounts = [
            '公休' => 0,
            '有休+半休' => 0,
            '有休日数' => 0.0,
            '振休' => 0,
            '特休' => 0,
            '欠勤' => 0,
            '産休' => 0,
            '育休' => 0,
        ];

        $halfDayCount=0;

        $halfDayDates = [];

        // foreach ($vacationRecords as $record) {
        //     if ($record->attendanceTypeRecord->name === '半休') {
        //         $halfDayDates[] = $record->date;
        //     }
        // }


//end array zarlaad halfdate tooloh um shig bna
//hednii udur hagas amralt awsan olj bna
        $halfDayVacationDates=[];

        foreach($vacationRecords as $record){
            if($record->attendanceTypeRecord->name ==='半休'){
                $halfDayVacationDates[]=Carbon::parse($record->date)->format('Y-m-d');
            }
        }


        $halfDayRecords = $user->userArrivalRecords()
            ->whereIn(DB::raw('DATE(recorded_at)'), $halfDayVacationDates)
            ->get()
            ->map(function($record) {
                $endTime = null;

        // Get departure time either from arrivalDepartureRecords or DepartureRecord
        if ($record->arrivalDepartureRecords->isNotEmpty()) {
            $endTime = Carbon::parse($record->arrivalDepartureRecords->first()->recorded_at)->format('H:i');
        } elseif ($record->DepartureRecord) {
            $endTime = Carbon::parse($record->DepartureRecord->recorded_at)->format('H:i');
        }

        return [
            'date' => Carbon::parse($record->recorded_at)->format('Y-m-d'),
            'arrival_time' => Carbon::parse($record->recorded_at)->format('H:i'),
            'departure_time' => $endTime
        ];
    });

        // dd($halfDayRecords);




        //shineer zarlah gej vzej bna

        $pregnantVacation=[];
        foreach ($vacationRecords as $record){
            if($record->attendanceTypeRecord->name === '産休'){
                $pregnantVacation[]=$record->date;
            }
        }
        // dd($pregnantVacation);

        $absentday=[];

        foreach($vacationRecords as $record){
            if($record->attendanceTypeRecord->name === '欠勤'){
                $absentday[]=$record->date;
            }
        }
        // dd($absentday);


        // Энэ хэсэгт addHoliday-р нэмэгдсэн амралтын өдрүүдийг авч ирнэ
        $officeId = $user->office->id;
        $addedHolidays = VacationCalendar::getHolidaysForRange($startDate, $endDate, $officeId);

        // Тооцоололд нэмэх
        $vacationRecordsCounts['公休'] += $addedHolidays->count();

        // dd($vacationRecordsCounts);

        // Calculate the total number of days in the month

        //AAAAAAAAAAAAA
        // $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $startDate1=Carbon::createFromDate($year, $month -1, 16);
            $endDate1=Carbon::createFromDate($year, $month, 15);
            $daysOfMonth=$endDate1->diffInDays($startDate1)+1;


        // dd($daysOfMonth);

        // Subtract the number of full-day vacations
        $daysOfMonth -= $vacationRecordsCounts['有休日数'];

        // Subtract half the number of half-day vacations
        $daysOfMonth -= ($vacationRecordsCounts['有休+半休'] - $vacationRecordsCounts['有休日数']) * 0.5;


        foreach ($vacationRecords as $record) {

            $type = $record->attendanceTypeRecord->name;

            if ($type === '半休') {
                $halfDayCount += 0.5; // Count half day as 0.5
            }




            if (array_key_exists($type, $vacationRecordsCounts)) {

                if($type==='半休'){
                    $vacationRecordsCounts[$type]+=0.5;
                }else{
                $vacationRecordsCounts[$type]++;


                }


                if ($type === '有休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 1.0, 1);
                } elseif ($type === '半休') {
                    $vacationRecordsCounts['有休+半休']+=0.5;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 0.5, 1);
                }
            }

            else {
                if ($type === '有休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 1.0, 2);
                } elseif ($type === '半休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 0.5, 2);
                } else {
                    // Log::info('User ' . $user->name . ': Vacation type "' . $type . '" is not being counted.');
                }
            }
        }

        // dd($halfDayCount,$vacationRecordsCounts);




        // Calculate the sum of all vacation records counts
        $totalVacationDays = array_sum($vacationRecordsCounts);

        // Subtract the worked holiday from the total vacation days
        $totalVacationDays += $totalWorkedHoliday;


        // Calculate the real total worked days
        // Энэ хэсэгт хэрэглэгчийн бүртгэл байгаа эсэхийг шалгаж, $daysOfMonth-д зохих утгыг онооно.


        $holiday = $vacationRecordsCounts['公休'];
        $allPaidHoliday = $vacationRecordsCounts['有休日数'] + $vacationRecordsCounts['特休'] + $vacationRecordsCounts['振休'];
        $totalHolidayWorked = $totalWorkedHoliday;


        //  $realTotalWorkedDay = $this->calculate($daysOfMonth, $holiday, $allPaidHoliday, $totalHolidayWorked);
        //  $subtractedWorkedDay = $realTotalWorkedDay - $totalWorkedHoliday;
//
// if ($user->id == 74) {
// dd(
//     [
//         'sariin udruud'=>$daysOfMonth,
//         'amralt udruud'=>$holiday,
//         'paid amralt udruud'=>$allPaidHoliday,
//         'amralt udruud ajilsan'=>$totalHolidayWorked,
//     ]
// );
// }
        $realTotalWorkedDay = (float) $this->calculate($daysOfMonth, $holiday, $allPaidHoliday, $totalHolidayWorked);
        $subtractedWorkedDay = number_format($realTotalWorkedDay - $totalWorkedHoliday, 2 );

        // dd([
        //                 'ajilsan udur'=>$realTotalWorkedDay,
        //                 'hassan udur'=>$subtractedWorkedDay
        //             ]);


        // dd($subtractedWorkedDay);


        if(!empty($pregnantVacation)){
            $subtractedWorkedDay -=count($pregnantVacation);
        }

        if(!empty($absentday)){
            $subtractedWorkedDay -= count($absentday);
        }
        // dd($subtractedWorkedDay);
        // Format the final value to two decimal places


        //variable zohiogood tendee haanaaas yaj awaad herhen toolohiin zaaj baina
        $holidayRecords = $this->getHolidays($user->office->corp_id, $user->office->id, $startDate, $endDate);
        $vacationRecordsCounts['公休'] = $holidayRecords->count() - $totalWorkedHoliday;
        // $vacationRecordsCounts['公休']-= count($pregnantVacation);
        // dd($vacationRecordsCounts);

        //endees irsen tsagaa duudaad dawtaj baina



        $arrivalRecords = $user
        ->userArrivalRecords()
        ->whereDate('recorded_at', '<=', $endDate)
        ->whereDate('recorded_at', '>=', $startDate)
        ->get()

        ->groupBy(function ($record) {
            return Carbon::parse($record->recorded_at)->format('Y-m-d');
        });


        //
     $breaks = Breaks::where('user_id', $user->id)
    ->whereBetween('start_time', [$startDate, $endDate])
    ->get()
    ->groupBy(function ($break) {
        return Carbon::parse($break->start_time)->format('Y-m-d');
    })
    ->map(function ($dayBreaks) {
        return $dayBreaks->sum(function ($break) {
            return $break->getTotalBreakTimeInMinutesWithSkip();
        });
    });



        $countWorkedDay = 0;
        $overtimeSecondsA = 0;
        $overtimeSecondsB = 0;
        $overtimeSecondsBB = 0;
        $overtimeSecondsC = 0;
        $lateArrivalSeconds = 0;
        $weekendOvertimeSeconds = 0;
        $morningOverTimeSeconds=0;

        // dd($weekendOvertimeSeconds);


        // Initialize variables outside the loop
        $totalOvertimeSecondsA = 0;
        $totalOvertimeSecondsB = 0;
        $totalOvertimeSecondsC = 0;
        $totalWeekendOvertimeSeconds = 0;
        $totalWorkedTime = 0;

        $totalhalfdayCalculation=0;


        foreach ($arrivalRecords as $date => $dailyRecords) {

            $dailyWorkedSeconds = 0;

            // $lateArrivalSeconds = 0;
            $overTimeSeconds = 0;


            // Get the total break time for this day
            // Get the break time for this date, if any
            $breakTimeInMinutes = $breaks[$date] ?? 0;
            $breakTimeInSeconds = $breakTimeInMinutes * 60;
            $dailyOvertimeSecondsA=0;
            $dailyOvertimeSecondsB=0;
            $morningOverTimeSeconds = 0;

            //shine

            $halfdayCalculation=0;


            foreach ($dailyRecords as $arrivalRecord) {

                $startTime = Carbon::parse($arrivalRecord->recorded_at)->format('H:i');//startTime recorded time
                $startTimeCarbon = Carbon::parse($startTime);


                $workStartTimeCarbon = Carbon::parse($workStartTimeConfig); // 8:30


                //FIrst LateArrivalSeconds

                // if ($startTime > $workStartTimeConfig && !in_array($date, $halfDayDates)) {
                //     $lateArrivalSeconds += Carbon::parse($startTime)->diffInSeconds(Carbon::parse($workStartTimeConfig));
                //     // dd($lateArrivalSeconds,$workStartTime,$startTime);

                // }
                $endTime = '';
                $departureRecords = $arrivalRecord->arrivalDepartureRecords;

                if ($departureRecords->isNotEmpty()) {
                    $firstDepartureRecord = $departureRecords->first();
                    $endTime = Carbon::parse($firstDepartureRecord->recorded_at)->format('H:i');
                }

                if ($arrivalRecord->DepartureRecord) {
                    $endTime = Carbon::parse($arrivalRecord->DepartureRecord->recorded_at)->format('H:i');
                }

                if ($startTime && $endTime) {
                    $endTimeCarbon = Carbon::parse($endTime);

                    //adding new
                    $overtimeSecondsA += $lateArrivalSeconds;

                //  dump([
                //     'late'=>$overtimeSecondsA
                //  ]);
                    //need to check condition here



                    // dump("17:40 $overtimeSecondsB - $arrivalRecord->user_id",$this->formatSeconds($overTimeSeconds));
                    //21300

                    $morningOvertimeStart = Carbon::parse($morningOverTime);
                    $morningOvertimeEnd = Carbon::parse($workStartTimeConfig);


                    if ($startTimeCarbon->between($morningOvertimeStart, $morningOvertimeEnd, true)) {

                        $overlapStart = max($startTimeCarbon, $morningOvertimeStart);
                        $overlapEnd = min($endTimeCarbon, $morningOvertimeEnd);
                        $morningOverTimeSeconds = $overlapEnd->diffInSeconds($overlapStart, true);
                        // dump(
                        //     [
                        //         'd'=>$morningOverTimeSeconds,

                        //     ]
                        // );
                        // $overtimeSecondsB+=$overlapEnd->diffInSeconds($overlapStart, true);
                        // $overtimeSecondsA=$morningOverTimeSeconds-$overtimeSecondsB;

                        // $overtimeSecondsA= $overtimeSecondsB-;

                    }




                    $overtimeStartB = Carbon::parse($startOverTime);
                    $overtimeEndB = Carbon::parse($endOverTime)->addDay();

                    if ($endTimeCarbon->between($overtimeStartB, $overtimeEndB, true)) {
                        $overlapStart = max($startTimeCarbon, $overtimeStartB);
                        $overlapEnd = min($endTimeCarbon, $overtimeEndB);
                        $overtimeSecondsB += $overlapEnd->diffInSeconds($overlapStart, true);

                        $overTimeSeconds = $overlapEnd->diffInSeconds($overlapStart, true);






                        // dd([
                        //     'overB'=>$overtimeSecondsB,
                        //     'LAP'=>$overlapEnd,
                        //     'overSe'=>$overTimeSeconds

                        // ]);
                    }

                    //   // Formula 1 - For overtimeSecondsA
                    // if(!empty($breakTimeInSeconds) || $lateArrivalSeconds >0){
                    //     $timeDiff1=$breakTimeInSeconds+max(0, $startTimeCarbon->timestamp-$workStartTimeCarbon->timestamp);

                    //     if($timeDiff1 > $overTimeSeconds){
                    //         $dailyOvertimeSecondsA+=$overTimeSeconds;
                    //         $dailyOvertimeSecondsB +=0;
                    //     }else{
                    //         $dailyOvertimeSecondsA+=$timeDiff1;
                    //         $dailyOvertimeSecondsB += max(0, $overTimeSeconds - $timeDiff1);
                    //     }


                    // }else{
                    //     $dailyOvertimeSecondsB+=$overTimeSeconds;
                    // }



                    //A-g shalgah

                    $hasHalfDayOff=$vacationRecords->contains(function($record) use ($date){
                        return $record->attendanceTypeRecord->name ==='半休'
                        && Carbon::parse($record->date)->format('Y-m-d')===$date;
                    });




// Formula 1 - For overtimeSecondsA

// if(!empty($breakTimeInSeconds) || $lateArrivalSeconds >0){
//     $timeDiff1=$breakTimeInSeconds+($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);

//     if($timeDiff1 > $overTimeSeconds){
//         $overtimeValue=$overTimeSeconds;
//     }else{
//         $overtimeValue=$timeDiff1;
//     }

//     if($hasHalfDayOff){
//         $dailyOvertimeSecondsB+=$overtimeValue;
//     }else{
//         $dailyOvertimeSecondsA+=$overtimeValue;
//     }
// }

// dd($lateArrivalSeconds);

// if(!empty($breakTimeInSeconds) || $lateArrivalSeconds >0){
//     $timeDiff1=($breakTimeInSeconds ?? 0)+
//                 $lateArrivalSeconds +
//                 ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);

//                 if($timeDiff1 > $overTimeSeconds)
//                 {
//                     $overtimeValue=$overTimeSeconds;
//                 }else{
//                     $overtimeValue=$timeDiff1;
//                 }

//                 if($hasHalfDayOff){
//                     $dailyOvertimeSecondsB +=$overtimeValue;
//                 }else{
//                     $dailyOvertimeSecondsA +=$overtimeValue;
//                 }


// }
// // if(!$hasHalfDayOff){
// //     if (!empty($breakTimeInSeconds) || $lateArrivalSeconds > 0) {
// //         // Calculate the time difference
// //         $timeDiff1 = $breakTimeInSeconds + ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);

// //         // Check if timeDiff1 exceeds overTimeSeconds
// //         if ($timeDiff1 > $overTimeSeconds) {
// //             $dailyOvertimeSecondsA += $overTimeSeconds;
// //         } else {
// //             // Set dailyOvertimeSecondsA based on timeDiff1
// //             $dailyOvertimeSecondsA += $timeDiff1;

// //             // Ensure dailyOvertimeSecondsA is not negative
// //             // if ($dailyOvertimeSecondsA < 0) {
// //             //     $dailyOvertimeSecondsA = 0;
// //             // }
// //         }
// //     }


// // }

// // Formula 2 - For overtimeSecondsB
// if (!empty($breakTimeInSeconds) || $lateArrivalSeconds > 0) {
//     // Calculate the same time difference as before
//     $timeDiff1 = $breakTimeInSeconds + ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);

//     // Check if timeDiff1 exceeds overTimeSeconds
//     if ($timeDiff1 > $overTimeSeconds) {
//         $dailyOvertimeSecondsB += 0; // Reset overtimeSecondsB to 0 in this case
//     } else {
//         // Set dailyOvertimeSecondsB based on overTimeSeconds and timeDiff1
//         $dailyOvertimeSecondsB += max(0, $overTimeSeconds - $timeDiff1);
//     }
// } else {
//     // If no break or late arrival, set full overtime to dailyOvertimeSecondsB
//     $dailyOvertimeSecondsB += $overTimeSeconds;

// }






                   // dump("17:40 $overtimeSecondsB - $arrivalRecord->user_id",$this->formatSeconds($overTimeSeconds));
                    // dd($overtimeSecondsB );
                    //24900

                    // dd($lateArrivalSeconds,$overTimeSeconds);
                    $lateFillSeconds = 0;
                    if ($lateArrivalSeconds > 0 && $overTimeSeconds > 0) {
                        if ($overTimeSeconds >= $lateArrivalSeconds) {
                            $lateFillSeconds = $lateArrivalSeconds;
                            $overTimeSeconds -= $lateArrivalSeconds;
                            //$overtimeSecondsB -= $lateArrivalSeconds;
                        } else {
                            $lateFillSeconds = $overTimeSeconds;
                            $overTimeSeconds -= $overTimeSeconds;
                            // $overtimeSecondsB += $lateArrivalSeconds;
                        }
                    }

                    // dd($overTimeSeconds);

                    // $overtimeSecondsA += $lateFillSeconds;
                        //   dump([
                        //     'a'=>$overtimeSecondsA,
                        //     'late'=>$lateFillSeconds,
                        //     'LATE2'=>$lateArrivalSeconds
                        //   ]);


                    $overtimeStartC = Carbon::parse($overTime2start);
                    $overtimeEndC = Carbon::parse($overTime2end)->addDay();

                    if ($endTimeCarbon->between($overtimeStartC, $overtimeEndC, true)) {
                        $overlapStart = max($startTimeCarbon, $overtimeStartC);
                        $overlapEnd = min($endTimeCarbon, $overtimeEndC);
                        $overtimeSecondsC += $overlapEnd->diffInSeconds($overlapStart, true);
                        //$overtimeSecondsB += $overlapEnd->diffInSeconds($overlapStart, true);
                    }
                    // dd($overtimeSecondsC);
                    //5700

                    if ($startTimeCarbon > Carbon::parse($workStartTimeConfig)
                    && !in_array($date, $halfDayDates)
                    && !Carbon::parse($date)->isWeekend()
                    && !in_array($date, $halfDayVacationDates)
                    ) {
                        $lateArrivalSeconds += $startTimeCarbon->diffInSeconds(Carbon::parse($workStartTimeConfig));
                        $countLate++;


                    }

                    // dd($lateArrivalSeconds);


                    // if ($endTimeCarbon < Carbon::parse($workEndDay) && !in_array($date, $halfDayDates)) {
                    //     $earlyLeave++;
                    // }

                    if($endTimeCarbon < Carbon::parse($workEndDay)
                    && !in_array($date, $halfDayDates)
                    && !Carbon::parse($date)->isWeekend()
                    && !in_array($date,$halfDayVacationDates)

                    ){
                $earlyLeave++;

                $breakSeconds=0;

                $lunchStartTime=Carbon::parse($date . '12:00:00');
                $lunchEndTime=Carbon::parse($date . '13:00:00');

                if($endTimeCarbon <= $lunchEndTime && Carbon ::parse($workEndDay) >= $lunchStartTime){
                    $breakSeconds=3600;
                }

                 {
                    $break1Start = Carbon::parse($date . ' 11:00:00');
                    $break1End = Carbon::parse($date . ' 11:10:00');

                    if ($endTimeCarbon <= $break1End && Carbon::parse($workEndDay) >= $break1Start) {
                        $breakSeconds += 600;
                    }

                    $break2Start = Carbon::parse($date . ' 15:00:00');
                    $break2End = Carbon::parse($date . ' 15:10:00');

                    if ($endTimeCarbon <= $break2End && Carbon::parse($workEndDay) >= $break2Start) {
                        $breakSeconds += 600;
                    }
                }





                $totalEarlySeconds=$endTimeCarbon->diffInSeconds(Carbon::parse($workEndDay));


                // $earlyLeaveHours +=$endTimeCarbon->diffInSeconds(Carbon::parse($workEndDay));
                $earlyLeaveHours += max(0, $totalEarlySeconds -$breakSeconds);
                // dd($earlyLeaveHours);
            }



            if(!empty($breakTimeInSeconds) || $lateArrivalSeconds > 0) {
                // Only use breakTime and lateTime, remove the timestamp difference
                $timeDiff1 = ($breakTimeInSeconds ?? 0) + $lateArrivalSeconds;

                if($timeDiff1 > $overTimeSeconds) {
                    $overtimeValue = $overTimeSeconds;
                } else {
                    $overtimeValue = $timeDiff1;
                }

                if($hasHalfDayOff) {
                    $dailyOvertimeSecondsB += $overtimeValue;
                } else {
                    $dailyOvertimeSecondsA += $overtimeValue;
                }
            }






            // Formula 2 - For overtimeSecondsB
            // if (!empty($breakTimeInSeconds) || $lateArrivalSeconds > 0) {
            //     // Calculate the same time difference as before
            //     $timeDiff1 = $breakTimeInSeconds + ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);

            //     // Check if timeDiff1 exceeds overTimeSeconds
            //     if ($timeDiff1 > $overTimeSeconds) {
            //         $dailyOvertimeSecondsB += 0; // Reset overtimeSecondsB to 0 in this case
            //     } else {
            //         // Set dailyOvertimeSecondsB based on overTimeSeconds and timeDiff1
            //         $dailyOvertimeSecondsB += max(0, $overTimeSeconds - $timeDiff1);
            //     }
            // } else {
            //     // If no break or late arrival, set full overtime to dailyOvertimeSecondsB
            //     $dailyOvertimeSecondsB += $overTimeSeconds;

            // }

            if (!empty($breakTimeInSeconds) || $lateArrivalSeconds > 0) {
                // Include both break time and late arrival
                $timeDiff1 = ($breakTimeInSeconds ?? 0) + $lateArrivalSeconds;

                // Debug to verify the calculations
                // dd([
                //     'breakTime' => ($breakTimeInSeconds ?? 0),
                //     'lateTime' => $lateArrivalSeconds,
                //     'timeDiff1' => $timeDiff1,
                //     'overTimeSeconds' => $overTimeSeconds,
                //     'remaining overtime' => max(0, $overTimeSeconds - $timeDiff1)
                // ]);

                if ($timeDiff1 > $overTimeSeconds) {
                    $dailyOvertimeSecondsB = 0;
                } else {
                    $dailyOvertimeSecondsB += max(0, $overTimeSeconds - $timeDiff1);
                }
            } else {
                $dailyOvertimeSecondsB += $overTimeSeconds;
            }

            // dd($dailyOvertimeSecondsB );





            // dd([
            //     'ert ywsan pisda'=>$earlyLeave,
            //     'sadfdsasfd'=>$earlyLeaveHours

            // ]);


                    if ($startTimeCarbon->between(Carbon::parse($morning), Carbon::parse($workEndDay), true) || $endTimeCarbon->between(Carbon::parse($morning), Carbon::parse($workEndDay), true)) {
                        $workedTimeInSeconds = $this->calculateWorkedTime($startTime, $endTime,$calculations,  $breakTimeInMinutes * 60);
                        $dailyWorkedSeconds += $workedTimeInSeconds;

                    }



                    if (
                        $arrivalRecord->user->office &&
                        $arrivalRecord->user->office->corp &&
                        $arrivalRecord->user->office->corp->corp_name === 'ユメヤ'
                    ) {


                        $arrivalSecondTime = $arrivalRecord
                            ? Carbon::parse($arrivalRecord->second_recorded_at)->setTimezone(config('app.timezone'))
                            : null;
                        $departureSecondTime =
                            $arrivalRecord && $arrivalRecord->arrivalDepartureRecords->count()
                                ? Carbon::parse(
                                    $arrivalRecord->arrivalDepartureRecords->first()->second_recorded_at,
                                )->setTimezone(config('app.timezone'))
                                : null;


                        if ($arrivalSecondTime && $departureSecondTime) {
                            $result = workTimeCalc($arrivalSecondTime->format('H:i'), $departureSecondTime->format('H:i'));
                        } else {
                            $result = null;
                        }
                        if ($arrivalSecondTime && $departureSecondTime) {
                            $workedSecondStartTime = strtotime($arrivalSecondTime->format('H:i'));
                            $workedSecondEndTime = strtotime($departureSecondTime->format('H:i'));
                            if ($workedSecondEndTime - $workedSecondStartTime > 0) {
                                $secondTotalWorkedMinutes = ($workedSecondEndTime - $workedSecondStartTime);
                                $dailyWorkedSeconds += $secondTotalWorkedMinutes;
                            }
                        }

                    }

                }
            }





       // Accumulate daily totals to overall totals

    //    if($hasHalfDayOff){

    //     $workEndDay='12:30';


    //     $earlyLeaveHours +=$endTimeCarbon->diffInSeconds(Carbon::parse($workEndDay));

    //     // dd($earlyLeaveHours);

    //     $totalOvertimeSecondsA += $dailyOvertimeSecondsA + $morningOverTimeSeconds+$overTimeSeconds;
    //     // $totalOvertimeSecondsB += $dailyOvertimeSecondsB;
    //     $dailyWorkedSeconds-=$overTimeSeconds;
    //     // dd($dailyWorkedSeconds);
    //    }
    //    else{

    //      $totalOvertimeSecondsA += $dailyOvertimeSecondsA;
    //      $totalOvertimeSecondsB += $dailyOvertimeSecondsB+$morningOverTimeSeconds;

    //    }
    //      $totalWorkedTime +=$dailyWorkedSeconds;
    if($hasHalfDayOff) {
        $startTimeObj=Carbon::parse($startTime);
        $morningShiftStart=Carbon::parse('06:00');
        $morningShiftEnd=Carbon::parse('11:00');
        $afternoonShiftStart=Carbon::parse('13:00');
        $afternoonShiftEnd=Carbon::parse('15:00');

        if($startTimeObj ->between($morningShiftStart, $morningShiftEnd)){
            $workEndDay='12:30';
        }elseif($startTimeObj->between($afternoonShiftStart, $afternoonShiftEnd)){
            $workEndDay='17:30';
        }


        // dd($workEndDay);









        $earlyLeaveHours += $endTimeCarbon->diffInSeconds(Carbon::parse($workEndDay));

        // Convert 3 hours and 50 minutes to seconds
        $maxOvertimeA = (3 * 3600) + (50 * 60); // 3:50 in seconds

        $currentOvertimeA = $dailyOvertimeSecondsA + $morningOverTimeSeconds + $overTimeSeconds;

        if($currentOvertimeA > $maxOvertimeA) {
            // If overtime exceeds 3:50, split it
            $excessOvertime = $currentOvertimeA - $maxOvertimeA;
            $totalOvertimeSecondsA = $maxOvertimeA;
            $totalOvertimeSecondsB += $excessOvertime;
        } else {
            // If overtime is less than or equal to 3:50, keep it all in A
            $totalOvertimeSecondsA += $currentOvertimeA;
        }

        $dailyWorkedSeconds -= $overTimeSeconds;
    } else {
        // For normal days, apply the same logic


              $totalOvertimeSecondsA += $dailyOvertimeSecondsA;
         $totalOvertimeSecondsB += $dailyOvertimeSecondsB+$morningOverTimeSeconds;
    }

    $totalWorkedTime += $dailyWorkedSeconds;







    // $totalOvertimeSecondsA += $dailyOvertimeSecondsA;
    // $totalOvertimeSecondsB += $dailyOvertimeSecondsB+$morningOverTimeSeconds;
    // $totalWorkedTime += $dailyWorkedSeconds;



        // dump([

        //     'total'=>$totalOvertimeSecondsB,
        //     'odorbvriin'=>$dailyOvertimeSecondsB,
        //     'ogloonii ilvv tsag'=>$morningOverTimeSeconds
        // ]);
        // dump([
        //     'Final A' => $totalOvertimeSecondsA,
        //     // 'daily'=>$dailyOvertimeSecondsA

        // ]);



            // dd($overTimeSeconds,$overtimeSecondsA);

            //saraa hedneed hedniig hvrtelheer ni dawtaj baina

            $startDate = Carbon::createFromDate($year, $month, 16);
            // $endDate = Carbon::createFromDate($year, $month, 16)->addMonths(1)->subDay();
            $endDate = Carbon::createFromDate($year, $month, 16)->addMonths(1);
            $daysInMonth = $endDate->diffInDays($startDate) + 1;

            // dd([
            //     'udur'=>$daysInMonth
            // ]);


            // Subtract the number of holidays from the total days

            $daysInMonth -= $vacationRecordsCounts['公休'];


            //     dd([
            //     'udur'=>$daysInMonth
            // ]);


            //subsract break time from daily worked time

            // $totalWorkedTime += $dailyWorkedSeconds;

            $date = Carbon::parse($date);
            if ($date->isWeekend()) {
                $totalWorkedHoliday++;
                if ($dailyWorkedSeconds > ($workDayMinutes * 60)) {
                    $weekendOvertimeSeconds += ($dailyWorkedSeconds - ($workDayMinutes * 60));
                }
            } else {
                // $countWorkedDay = $daysInMonth;
            }
            // dd($daysInMonth);

            // $totalOverWorkedTimeA

            // if ($startTimeCarbon > Carbon::parse('08:30') && !in_array($date, $halfDayDates)) {
            //     $lateArrivalSeconds += $startTimeCarbon->diffInSeconds(Carbon::parse('08:30'));
            //     $countLate++;
            // }
            // dd($timeDiff1);
            // dd($countLate);

            // dump([
//     'Final A' => $overWorkedTimeB,

// ]);

// $Bpisda=($morningOverTimeSeconds+$overTimeSeconds)-$totalOvertimeSecondsA;
// dump([
//     'GF'=>$morningOverTimeSeconds,
//     'GG'=>$overTimeSeconds,
//     'a'=>$totalOvertimeSecondsA,
//     'A2'=>$overtimeSecondsA,
//     'b1'=>$overtimeSecondsB,

// ]);

// $countLateTime+=$lateArrivalSeconds;

// dd([
//     'lalarchinbaaDana'=>$countLateTime
// ]);
// $totalLateTime=$this->formatSeconds($countLateTime);

// dd($totalLateTime);




        }


       // Debug dump after the loop


// dump([
//     'D'=>$weekendOvertimeSeconds,
//     // 'sda danaa'=>$totalWeekendOvertimeSeconds
// ]);

  // Final calculations


$totalOverWorkedTimeA = $this->formatSeconds($totalOvertimeSecondsA);

// dd([
//     'a'=>$totalOverWorkedTimeA,
//     'seconds'=>$totalOvertimeSecondsA,
// ]);
$totalOverWorkedTimeC = $this->formatSeconds($overtimeSecondsC);
$overWorkedTimeB = $this->formatSeconds($totalOvertimeSecondsB);
$overWorkedTimeD = $this->formatSeconds($weekendOvertimeSeconds);



$countLateTime+=$lateArrivalSeconds;

$totalLateTime=$this->formatSeconds($countLateTime);

$totalEarlyLeaveTime=$this->formatSeconds($earlyLeaveHours);

$allBreakTime+=$breakTimeInSeconds;

// dd([
//     'all'=>$allBreakTime,
//     'seconds'=>$breakTimeInSeconds,
// ]);


$totalBreakTime=$this->formatSeconds($allBreakTime);
// dd($earlyLeaveHours);











        // $overWorkedTimeB+=
        // dump([
        //     'b second'=>$overtimeSecondsB,
        //     'a second'=>$totalOvertimeSecondsA,
        // ]);


        //$totalOverWorkedTimeA = $this->formatSeconds($totalOverWorkedTimeA);

        // $subtractedOverWorkedTimeB = $this->formatSeconds(max(0, Carbon::parse($overWorkedTimeB)->diffInSeconds(Carbon::parse($overWorkedTimeD))));





        $subtractedOverWorkedTimeB = '00:00:00';
        // dump([
        //     'b second'=>$overtimeSecondsB,
        //     'sda'=>$subtractedOverWorkedTimeB
        // ]);

        if ($this->isValidTimeString($overWorkedTimeB) && $this->isValidTimeString($overWorkedTimeD)) {
            $diffInSeconds = $this->getTimeDifferenceInSeconds($overWorkedTimeB, $overWorkedTimeD);
            $subtractedOverWorkedTimeB = $this->formatSeconds3($diffInSeconds);
        }

        // dd([

        //     'overWorkedTimeA'=>$totalOvertimeSecondsA,
        //     'overWorkedTimeB'=>$subtractedOverWorkedTimeB,


        // ]);


        //           $subtractedOverWorkedTimeB = $this->formatSeconds(max(0, Carbon::parse($overWorkedTimeB)->diffInSeconds(Carbon::parse($overWorkedTimeD))));
        // if ($this->isValidTimeString($overWorkedTimeB) && $this->isValidTimeString($overWorkedTimeD)) {
        //     $subtractedOverWorkedTimeB = $this->formatSeconds3(max(0, Carbon::parse($overWorkedTimeB)->diffInSeconds(Carbon::parse($overWorkedTimeD))));
        // }

        // if($this->isValidTimeString($overWorkedTimeB) && $this->isValidTimeString($overWorkedTimeD)){
        //     $diffInSeconds=max(0, Carbon::parse($overWorkedTimeB)->diffInSeconds(Carbon::parse($overWorkedTimeD)));

        //     $subtractedOverWorkedTimeB=$this->formatSeconds3($diffInSeconds);
        // }

        // dd([
        //     'lalarchinbaa'=>$subtractedOverWorkedTimeB,
        //     'lalarDanaa'=>$overWorkedTimeD,
        //   ]);





        $formattedTotalWorkedTime = $this->formatSeconds($totalWorkedTime);
        $formattedLateSeconds = $this->formatSeconds($lateArrivalSeconds);

        $totalCheckedHoursSeconds=$this->formatSeconds($checkedHoursSeconds);
        $totalCheckedHoursSeconds2=$this->formatSeconds($checkedHoursSeconds2);


        $totalexcessHoursSeconds=$this->formatSeconds($excessHoursSeconds);
        $totalexcessHoursSeconds2=$this->formatSeconds($excessHoursSeconds2);
        $totalShinyaWeekends=$this->formatSeconds($shinyaWeekends);

        // dd($totalShinyaWeekends,$shinyaWeekends);



// dump([
//     'lalar Chinbaa'=>$subtractedOverWorkedTimeB
// ]);
// dd($subtractedWorkedDay);
// if ($user->id == 74) {
//     dd([
//         'ajilsan udur' => $subtractedWorkedDay,
//         'user_id' => $user->id
//     ]);
// }

// dd($countLate);


// dd($halfDayVacationDates, $formattedTotalWorkedTime);
// dd($checkedHours);

        return [
            'staff_number' => $user->employer_id,
            'name' => $user->name,
            'workedDay' => number_format($subtractedWorkedDay, 1, '.', ''),
            'workedHoliday' => (int) $totalWorkedHoliday,
            'workedTime' => $formattedTotalWorkedTime,
            'countLate' => $countLate,
            'earlyLeave' => $earlyLeave,
            'vacationRecordsCounts' => $vacationRecordsCounts,
            'overWorkedTimeA' => $this->formatSeconds($totalOvertimeSecondsA) ?: '00:00:00',
            'overWorkedTimeB' => $subtractedOverWorkedTimeB,
            'overWorkedTimeC' => $totalOverWorkedTimeC,
            'overWorkedTimeD' => $overWorkedTimeD,

            'totalLateTime'=>$totalLateTime,
            'totalEarlyLeaveTime'=>$totalEarlyLeaveTime,
            'totalBreakTime'=>$totalBreakTime,

            'totalWeekendOvertimeSaturday'=>$totalexcessHoursSeconds,
            'totalWeekendOvertimeSunday'=>$totalexcessHoursSeconds2,

            'totalShinyaWeekends'=>$totalShinyaWeekends,

            'totalCheckboxTime'=>$totalCheckedHoursSeconds,
            'totalCheckboxTime2'=>$totalCheckedHoursSeconds2,


        ];


    }



    private function calculateValidMinutes($start, $end, $skipStart, $skipEnd)
    {
        // If the break is entirely within the skip range
        if ($end <= $skipStart || $start >= $skipEnd) {
            return $end->diffInMinutes($start);
        }

        // Adjust the end time if it overlaps with the skip time
        if ($start < $skipStart && $end > $skipStart) {
            return $skipStart->diffInMinutes($start); // Time before skip range
        }

        if ($start < $skipEnd && $end > $skipEnd) {
            return $end->diffInMinutes($skipEnd); // Time after skip range
        }

        return $end->diffInMinutes($start); // No overlap with skip time
    }

    private function calculate($daysOfMonth, $holiday, $allPaidHoliday, $totalHolidayWorked)
    {
        // Calculate the sum of holidays and all paid holidays
        $sumHolidays = $holiday + $allPaidHoliday;

        // Calculate the total worked days, considering the $totalHolidayWorked
        $totalWorkedDay = $daysOfMonth - $sumHolidays;

        // Adjust the total worked days by subtracting the days that were worked on holidays
        $totalWorkedDay -= $totalHolidayWorked;

        return $totalWorkedDay;
    }


    private function calculateWorkedTime($startTime, $endTime, $calculations, $breakTimeInSeconds = 0)
    {

         // Assume $currentUser is passed or accessible
    // $currentUser = auth()->user();
    // $date = \Carbon\Carbon::parse($startTime)->format('Y-m-d');

    // // Check if the user has a TimeOffRequestRecord for this date with 'halfday' (半休)
    // $timeOffRequest = TimeOffRequestRecord::where('user_id', $currentUser->id)
    //     ->whereDate('date', $date)
    //     ->whereHas('attendanceTypeRecord', function ($query) {
    //         $query->where('name', '半休');
    //     })
    //     ->first();

    //     // dd($timeOffRequest);

    // // Skip logic if a halfday TimeOffRequestRecord exists
    // if ($timeOffRequest) {
    //     return 0; // or null, or any default value you'd like to indicate skipped logic
    // }


    $IQ6 = $this->timeToMinutes($this->getCalculationValue($calculations, '9'));
    $IQ7 = $this->timeToMinutes($this->getCalculationValue($calculations, '10'));
    $IQ8 = $this->timeToMinutes($this->getCalculationValue($calculations, '11'));
    $IQ10 = $this->timeToMinutes($this->getCalculationValue($calculations, '12'));//17:30
    $IQ11 = $this->timeToMinutes($this->getCalculationValue($calculations, '13'));//17:40
    // $IQ12 = intval($this->getCalculationValue($calculations, '14'));//10
    $IQ12=$this->timeToMinutes($this->getCalculationValue($calculations,'14'));
    $IQ17 = $this->timeToMinutes($this->getCalculationValue($calculations, '15') );//12:30
    // $IQ20 = intval($this->getCalculationValue($calculations, '16'));//3:50
    $IQ20=$this->timeToMinutes($this->getCalculationValue($calculations, '16'));

    $departureMinutes = $this->timeToMinutes($endTime);
    $arrivalMinutes = $this->timeToMinutes($startTime);
    $lunchTimeStartMinutes = $this->timeToMinutes($this->getCalculationValue($calculations, '17'));//12:00
    $lunchTimeEndMinutes = $this->timeToMinutes($this->getCalculationValue($calculations, '18'));//13:00




            if ($endTime == "") {
                $time1 = 0;
            } else {
                if ($departureMinutes == $IQ17) {
                    $time1 = $IQ20;
                } else {
                    if ($arrivalMinutes < $IQ6) {
                        $arrivalAdjustment = $IQ6 - $arrivalMinutes;
                    } else {
                        $arrivalAdjustment = 0;
                    }

                    if ($departureMinutes <= $IQ6) {
                        $departureAdjustment = $IQ6 - $departureMinutes;
                    } else {
                        $departureAdjustment = 0;
                    }

                    $time1 = $arrivalAdjustment - $departureAdjustment;
                }

            }

            // dd($time1);








        // Formula 1


        // Formula 2
        $arrivalTimeAdjusted = ($arrivalMinutes > $IQ7) ? $arrivalMinutes : $IQ7;

        // Formula 3
        $departureTimeAdjusted = ($departureMinutes < $IQ8) ? $departureMinutes : $IQ8;

        // Formula 4
        $lunchDuration = ($lunchTimeEndMinutes < $lunchTimeStartMinutes) ? 0 : $lunchTimeEndMinutes - $lunchTimeStartMinutes;

        // Formula 6: Calculating $breakBeforeOverTime
        if ($departureMinutes >= $IQ11) {
            $breakBeforeOverTime = $IQ12;
        } elseif ($departureMinutes <= $IQ10) {
            $breakBeforeOverTime = 0;
        } else {
            $breakBeforeOverTime = $departureMinutes - $IQ10;
        }

        // Formula 5
        try {
            if ($departureMinutes <= $IQ8) {
                $time5 = 0;
            } else {
                if ($arrivalMinutes >= $IQ8) {
                    $time5 = $departureMinutes - $arrivalTimeAdjusted - $IQ12 - $breakBeforeOverTime;
                } else {
                    $time5 = $departureMinutes - $IQ8 - $IQ12 - $breakBeforeOverTime;
                }
            }
        } catch (Exception $e) {
            $time5 = 0;
        }
        // dd([
        //     'fdasdf'=>$breakTimeInSeconds,
        // ]);
        // Formula 7
        $totalWorkedTime = ($time1 + $time5) * 60;


        //Hamgiin chuhal hasah vildel

        $totalWorkedTime=max(0, $totalWorkedTime- $breakTimeInSeconds);

        return $totalWorkedTime;







    }



    private function timeToMinutes($time)

    {
        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    private function minutesToTime($minutes)

    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return sprintf("%02d:%02d", $hours, $minutes);
    }


    public function download(Request $request)

    {
//         // $workDayMinutes = 7 * 60 + 40;
//         $corp = Corp::find($request->corp_id);
//   // Add safety check
//   if ($corp && $corp->corp_name === 'ユメヤ') {
//     $workDayMinutes = 8 * 60;
//     dd($workDayMinutes);
// } else {
//     $workDayMinutes = 7 * 60 + 40;
//     dd($workDayMinutes);

// }




        $month = $request->month;
        $selectedCorpId = $request->input('corps_id');
        $selectedYear = $request->input('year', date('Y'));
        $selectedOfficeId = $request->input('office_id');

        $corp = Corp::find($selectedCorpId);

    // Set work minutes based on company name
    $workDayMinutes = ($corp && $corp->corp_name === 'ユメヤ') ? (8 * 60) : (7 * 60 + 40);

        // $startDate = Carbon::parse(date("Y-$month-16"));
        // $endDate = Carbon::parse($startDate->copy()->addMonth()->format('Y-m-15'));
        $startDate=Carbon::parse("$selectedYear-$month-16")->subMonth();
        $endDate=Carbon::parse("$selectedYear-$month-15");

        $startDateForCountWeekend = $startDate->copy();
        $startDateForCountWorkDay = $startDate->copy();
        $totalWeekend = 0;

        while ($startDateForCountWeekend->lte($endDate)) {
            if ($startDateForCountWeekend->isWeekend()) {
                $totalWeekend++;
            }
            $startDateForCountWeekend->addDay();
        }



        $totalWorkDay = 0;
        while ($startDateForCountWorkDay->lte($endDate)) {
            if (!$startDateForCountWorkDay->isWeekend()) {
                $totalWorkDay++;
            }
            $startDateForCountWorkDay->addDay();
        }

        $calculations = Calculation::get()->all();

        $calculationNumbers = [];
        $calculationNumber = "";

        for ($i = 0; $i < count($calculationNumbers); $i++) {
            $calculationNumber = $calculationNumbers[$i];
            $calculation = array_filter($calculations, function ($row) use ($calculationNumber) {
                return $row->number == $calculationNumber;
            });

            if (empty($calculation)) {
                throw new Exception("Calculation not set $calculationNumber");
            }
        }

        // dd($calculations);


        if ($selectedOfficeId) {
            $users = User::whereHas('office', function ($query) use ($selectedOfficeId) {
                $query->where('id', $selectedOfficeId);
            })->get();
        } else {
            if ($selectedCorpId) {
                $users = User::whereHas('office', function ($query) use ($selectedCorpId) {
                    $query->where('corp_id', $selectedCorpId);
                })->get();
            } else {
                $users = User::get();
            }
        }

        foreach ($users as $user) {

            $corp_id=$user->office->corp_id;
            $row[] = $this->userTimeReportCollect($user, $startDate, $endDate, $workDayMinutes, $totalWorkDay, $totalWeekend, $month, $selectedYear, $corp_id, $calculations);
        }

        $headers = [
            'Content-Type' => 'text/csv; charset=Shift-JIS',
    'Content-Disposition' => sprintf('attachment; filename="%s.csv"', $month),
        ];
  // $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $japaneseHeaders = [
            '社員番号(必須)',
            '社員氏名(ﾃﾝﾌﾟﾚｰﾄ項目)',
            '平日出勤',
            '休日出勤',
            '出勤時間',
            '遅刻',
            '早退',
            '有休日数',
            '代休',
            '公休',
            'その他の休日',
            '休職日数',
            '欠勤日数',
            '時間外手当時間Ａ',
            '時間外手当時間Ｂ',
            '時間外手当時間Ｃ',
            '時間外手当時間Ｄ',

            '遅刻時間',
            '早退時間',
            '休憩時間',

            '休日時間外（土・祝）',
            '休日時間外（日）',
            '休日深夜',
            '支給時間１（土、公休）',
            '支給時間２（日曜日のみ）'

        ];

        $encodedHeaders = array_map(function($header) {
            return mb_convert_encoding($header, 'SJIS-win', 'UTF-8');
        }, $japaneseHeaders);

        $csv->insertOne($encodedHeaders);


        foreach ($row as $values) {


            $encodedValues = array_map(function($value) {
                return mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
            },[




                $values['staff_number'],
                $values['name'],
            // sprintf('%01.1f', (float)$values['workedDay']),
            $values['workedDay'] = (string)number_format((float)$values['workedDay'], 1, '.', ''),


                $values['workedHoliday'],
                $values['workedTime'] = str_replace(':', '.', $values['workedTime']),
                $values['countLate'],
                $values['earlyLeave'],
                sprintf('%01.1f', (float)$values['vacationRecordsCounts']['有休日数']),
                $values['vacationRecordsCounts']['振休'],
                $values['vacationRecordsCounts']['公休'],
                $values['vacationRecordsCounts']['特休'],
                $values['vacationRecordsCounts']['']=0,
                $values['vacationRecordsCounts']['欠勤'],
                $values['overWorkedTimeA'] = str_replace(':', '.', $values['overWorkedTimeA']),
                $values['overWorkedTimeB'] = str_replace(':', '.', $values['overWorkedTimeB']),
                $values['overWorkedTimeC'] = str_replace(':', '.', $values['overWorkedTimeC']),
                $values['overWorkedTimeD'] = str_replace(':', '.', $values['overWorkedTimeD']),
                $values['totalLateTime'] =str_replace(':', '.', $values['totalLateTime']),
                $values['totalEarlyLeaveTime'] =str_replace(':', '.', $values['totalEarlyLeaveTime']),
                $values['totalBreakTime'] =str_replace(':', '.', $values['totalBreakTime']),







                $values['totalWeekendOvertimeSaturday']=str_replace(':', '.', $values['totalWeekendOvertimeSaturday']),
                $values['totalWeekendOvertimeSunday']=str_replace(':', '.', $values['totalWeekendOvertimeSunday']),
                $values['totalShinyaWeekends']=str_replace(':', '.', $values['totalShinyaWeekends']),

                $values['totalCheckboxTime']=str_replace(':', '.', $values['totalCheckboxTime']),
                $values['totalCheckboxTime2']=str_replace(':', '.', $values['totalCheckboxTime2']),

            ]);
            // dd([
            //     'type' => gettype($values['overWorkedTimeB']),

            // ]);
            $csv->insertOne($encodedValues);
        }

        return FileResponse::make($csv, 200, $headers);
    }
}


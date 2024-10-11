<?php


namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Corp;
use App\Models\User;
use App\Models\Office;
use App\Models\Breaks;
use League\Csv\Writer;
use Illuminate\Http\Request;
use App\Models\ArrivalRecord;
use App\Models\Calculation;
use App\Models\DepartureRecord;
use App\Models\VacationCalendar;
use Illuminate\Support\Facades\CSV;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Response as FileResponse;

class CSVController extends Controller
{


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




    private function isValidTimeString($timeString)
    {
        try {
            Carbon::parse($timeString);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
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

        $halfDayDates = [];

        foreach ($vacationRecords as $record) {
            if ($record->attendanceTypeRecord->name === '半休') {
                $halfDayDates[] = $record->date;
            }
        }
        // dd($halfDayDates);
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

        // Calculate the total number of days in the month
        $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Subtract the number of full-day vacations
        $daysOfMonth -= $vacationRecordsCounts['有休日数'];

        // Subtract half the number of half-day vacations
        $daysOfMonth -= ($vacationRecordsCounts['有休+半休'] - $vacationRecordsCounts['有休日数']) * 0.5;


        foreach ($vacationRecords as $record) {

            $type = $record->attendanceTypeRecord->name;

            if (array_key_exists($type, $vacationRecordsCounts)) {
                $vacationRecordsCounts[$type]++;

                if ($type === '有休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 1.0, 2);
                } elseif ($type === '半休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 0.5, 2);
                }
            } else {
                if ($type === '有休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 1.0, 2);
                } elseif ($type === '半休') {
                    $vacationRecordsCounts['有休+半休']++;
                    $vacationRecordsCounts['有休日数'] = number_format($vacationRecordsCounts['有休日数'] + 0.5, 2);
                } else {
                    Log::info('User ' . $user->name . ': Vacation type "' . $type . '" is not being counted.');
                }
            }
        }




        // Calculate the sum of all vacation records counts
        $totalVacationDays = array_sum($vacationRecordsCounts);

        // Subtract the worked holiday from the total vacation days
        $totalVacationDays += $totalWorkedHoliday;


        // Calculate the real total worked days
        // Энэ хэсэгт хэрэглэгчийн бүртгэл байгаа эсэхийг шалгаж, $daysOfMonth-д зохих утгыг онооно.


        $holiday = $vacationRecordsCounts['公休'];
        $allPaidHoliday = $vacationRecordsCounts['有休+半休'] + $vacationRecordsCounts['特休'] + $vacationRecordsCounts['振休'];
        $totalHolidayWorked = $totalWorkedHoliday;


        //  $realTotalWorkedDay = $this->calculate($daysOfMonth, $holiday, $allPaidHoliday, $totalHolidayWorked);
        //  $subtractedWorkedDay = $realTotalWorkedDay - $totalWorkedHoliday;


        $realTotalWorkedDay = (float) $this->calculate($daysOfMonth, $holiday, $allPaidHoliday, $totalHolidayWorked);
        $subtractedWorkedDay = number_format($realTotalWorkedDay - $totalWorkedHoliday, 2 );


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
        $breaks=Breaks::where('user_id', $user->id)
        ->whereBetween('start_time', [$startDate,$endDate])
        ->get()
        ->groupBy(function ($break){
            return Carbon::parse($break->start_time)->format('Y-m-d');
        })
        ->map(function ($dayBreaks){
            return $dayBreaks->sum(function ($break){
                return $break->getTotalBreakTimeInMinutes();
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

        foreach ($arrivalRecords as $date => $dailyRecords) {

            $dailyWorkedSeconds = 0;

            $lateArrivalSeconds = 0;
            $overTimeSeconds = 0;


            // Get the total break time for this day
            // Get the break time for this date, if any
            $breakTimeInMinutes = $breaks[$date] ?? 0;
            $breakTimeInSeconds = $breakTimeInMinutes * 60;


            foreach ($dailyRecords as $arrivalRecord) {

                $startTime = Carbon::parse($arrivalRecord->recorded_at)->format('H:i');

                if ($startTime > $workStartTimeConfig && !in_array($date, $halfDayDates)) {
                    $lateArrivalSeconds += Carbon::parse($startTime)->diffInSeconds(Carbon::parse($workStartTimeConfig));
                    // dd($lateArrivalSeconds,$workStartTime,$startTime);

                }
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
                    $startTimeCarbon = Carbon::parse($startTime);
                    $endTimeCarbon = Carbon::parse($endTime);

                    $workStartTimeCarbon = Carbon::parse($workStartTimeConfig); // 8:30
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

                    }

                      // Formula 1 - For overtimeSecondsA




                      if (!empty($breakTimeInSeconds) || !empty($lateArrivalSeconds)) {
                        $timeDiff1 = $breakTimeInSeconds + ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);


                        if ($timeDiff1 > $overTimeSeconds) {
                            // dd($overtimeSecondsB);
                            $overtimeSecondsA = $overTimeSeconds;
                            // $overtimeSecondsB+=($startTimeCarbon->diffInSeconds($workStartTimeCarbon))-$breakTimeInSeconds;
                            // $overtimeSecondsB+=$morningOverTimeSeconds;

                        } else {
                            $overtimeSecondsA = $breakTimeInSeconds + ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);

                            // Check if the calculated $overtimeSecondsA is negative and set it to 0 if it is
                            if ($overtimeSecondsA < 0) {
                                $overtimeSecondsA = 0;
                                // $overtimeSecondsB+=$timeDiff1;
                            }


                        }
                    }
                      // Formula 2 - For overtimeSecondsB

                      if (!empty($breakTimeInSeconds) || !empty($lateArrivalSeconds)) {
                        $timeDiff1 = $breakTimeInSeconds + ($startTimeCarbon->timestamp - $workStartTimeCarbon->timestamp);


                        if ($timeDiff1 > $overTimeSeconds) {
                            // dd($overtimeSecondsB);
                            $overtimeSecondsB = 0;

                        } else {
                            // dd($overtimeSecondsB, $overTimeSeconds);
                            $overtimeSecondsB = $overTimeSeconds-$timeDiff1;


                        }

                    }
                    else{
                        $overTimeSecondsB=$overTimeSeconds;
                    }


                    $overtimeSecondsB+=$morningOverTimeSeconds;

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

                    //dd($overTimeSeconds);

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

                    if ($startTimeCarbon > Carbon::parse($workStartTimeConfig) && !in_array($date, $halfDayDates)) {
                        $lateArrivalSeconds += $startTimeCarbon->diffInSeconds(Carbon::parse($workStartTimeConfig));
                        $countLate++;
                    }

                    if ($endTimeCarbon < Carbon::parse($workEndDay) && !in_array($date, $halfDayDates)) {
                        $earlyLeave++;
                    }

                    if ($startTimeCarbon->between(Carbon::parse($morning), Carbon::parse($workEndDay), true) || $endTimeCarbon->between(Carbon::parse($morning), Carbon::parse($workEndDay), true)) {
                        $workedTimeInSeconds = $this->calculateWorkedTime($startTime, $endTime,$calculations,  $breakTimeInMinutes * 60);
                        $dailyWorkedSeconds += $workedTimeInSeconds;
                        // dd($dailyWorkedSeconds);
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


            //dd($overTimeSeconds,$overtimeSecondsA);

            //saraa hedneed hedniig hvrtelheer ni dawtaj baina

            $startDate = Carbon::createFromDate($year, $month, 16);
            $endDate = Carbon::createFromDate($year, $month, 16)->addMonths(1)->subDay();
            $daysInMonth = $endDate->diffInDays($startDate) + 1;


            // Subtract the number of holidays from the total days

            $daysInMonth -= $vacationRecordsCounts['公休'];


            //subsract break time from daily worked time

            $totalWorkedTime += $dailyWorkedSeconds;

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
        }

        // dump($overtimeSecondsA,$overtimeSecondsB);

        $totalOverWorkedTimeA = $this->formatSeconds( $totalOverWorkedTimeA);
        $totalOverWorkedTimeC = $this->formatSeconds($overtimeSecondsC);
        $overWorkedTimeB = $this->formatSeconds( $overtimeSecondsB);
        $overWorkedTimeD = $this->formatSeconds($weekendOvertimeSeconds);
        // dump([
        //     'a'=>$overtimeSecondsA,
        //     'totalA'=>$totalOverWorkedTimeA,
        //     'b'=>$overWorkedTimeB,
        // ]);



        // $overWorkedTimeB+=
        // dump([
        //     'b second'=>$overtimeSecondsB,
        //     'a second'=>$overtimeSecondsA,
        // ]);


        //$totalOverWorkedTimeA = $this->formatSeconds($totalOverWorkedTimeA);

        // $subtractedOverWorkedTimeB = $this->formatSeconds(max(0, Carbon::parse($overWorkedTimeB)->diffInSeconds(Carbon::parse($overWorkedTimeD))));
        $subtractedOverWorkedTimeB = '00:00:00';
        // dd($totalOverWorkedTimeA);

        if ($this->isValidTimeString($overWorkedTimeB) && $this->isValidTimeString($overWorkedTimeD)) {
            $subtractedOverWorkedTimeB = $this->formatSeconds(max(0, Carbon::parse($overWorkedTimeB)->diffInSeconds(Carbon::parse($overWorkedTimeD))));
        }


        $formattedTotalWorkedTime = $this->formatSeconds($totalWorkedTime);
        $formattedLateSeconds = $this->formatSeconds($lateArrivalSeconds);


        return [
            'staff_number' => $user->id,
            'name' => $user->name,
            'workedDay' => number_format($subtractedWorkedDay, 1, '.', ''),
            'workedHoliday' => (int) $totalWorkedHoliday,
            'workedTime' => $formattedTotalWorkedTime,
            'countLate' => $countLate,
            'earlyLeave' => $earlyLeave,
            'vacationRecordsCounts' => $vacationRecordsCounts,
            'overWorkedTimeA' => $this->formatSeconds($overtimeSecondsA) ?: '00:00:00',
            'overWorkedTimeB' => $subtractedOverWorkedTimeB,
            'overWorkedTimeC' => $totalOverWorkedTimeC,
            'overWorkedTimeD' => $overWorkedTimeD,
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


        // $IQ6 = $this->timeToMinutes("11:50");
        // $IQ7 = $this->timeToMinutes("12:00");
        // $IQ8 = $this->timeToMinutes("13:00");
        // $IQ10 = $this->timeToMinutes("17:30");
        // $IQ11 = $this->timeToMinutes("17:40");
        // $IQ12 = 10;
        // $IQ17 = $this->timeToMinutes("12:30");
        // $IQ20 = 230;

        // $departureMinutes = $this->timeToMinutes($endTime);
        // $arrivalMinutes = $this->timeToMinutes($startTime);
        // $lunchTimeStartMinutes = $this->timeToMinutes("12:00");
        // $lunchTimeEndMinutes = $this->timeToMinutes("13:00");

        // Formula 1
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
        $workDayMinutes = 7 * 60 + 40;
        $month = $request->month;
        $selectedCorpId = $request->input('corps_id');
        $selectedYear = $request->input('year', date('Y'));
        $selectedOfficeId = $request->input('office_id');

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
            'Content-Disposition' => 'attachment; filename="' . $month . '.csv"',
        ];

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setOutputBOM(Writer::BOM_UTF8);

        $csv->insertOne([
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
        ]);

        foreach ($row as $values) {
            $csv->insertOne([
                $values['staff_number'],
                $values['name'],
            sprintf('%01.1f', (float)$values['workedDay']),
                $values['workedHoliday'],
                $values['workedTime'],
                $values['countLate'],
                $values['earlyLeave'],
                sprintf('%01.1f', (float)$values['vacationRecordsCounts']['有休日数']),
                $values['vacationRecordsCounts']['振休'],
                $values['vacationRecordsCounts']['公休'],
                $values['vacationRecordsCounts']['特休'],
                $values['vacationRecordsCounts']['']=0,
                $values['vacationRecordsCounts']['欠勤'],
                $values['overWorkedTimeA'],
                $values['overWorkedTimeB'],
                $values['overWorkedTimeC'],
                $values['overWorkedTimeD'],
            ]);
        }

        return FileResponse::make($csv, 200, $headers);
    }
}


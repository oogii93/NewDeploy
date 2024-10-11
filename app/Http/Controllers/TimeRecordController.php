<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Carbon\Carbon;
use App\Models\Breaks;
use Illuminate\Http\Request;
use App\Models\ArrivalRecord;
use App\Models\DepartureRecord;
use App\Rules\RecordedAtExistsRule;
use App\Http\Controllers\Controller;


class TimeRecordController extends Controller
{


    public function checkRecord(Request $request, $recordType)
    {
        $user = $request->user();
        $date = $request->input('date', now()->toDateString()); // Default to today if no date is provided
        $fixDate = \Carbon\Carbon::parse($date);
        $check = 0;

        switch ($recordType) {
            case 'ArrivalRecord':
                $exists = ArrivalRecord::where('user_id', $user->id)
                    ->whereDate('recorded_at', $fixDate->format("Y-m-d"))  // Compare only the date (Y-m-d)
                    ->exists();
                break;

            case 'SecondArrivalRecord':
                $data = ArrivalRecord::where('user_id', $user->id)
                    ->whereDate('recorded_at', $fixDate->format("Y-m-d"))->first();
                if ($fixDate < $data->arrivalDepartureRecords->first()->recorded_at) {
                    $check++;
                }
                $exists = ArrivalRecord::where('user_id', $user->id)
                    ->whereDate('second_recorded_at', $fixDate->format("Y-m-d"))  // Compare only the date (Y-m-d)
                    ->exists();
                break;

            // DepartureRecord and SecondDepartureRecord will be handled in the frontend
        }

        return response()->json(['exists' => $check == 0 ? $exists : 2]);
    }








    private function hasArrivalAndDepartureRecords($user, $date)
    {
        // Check if both Arrival and Departure records exist for the given day
        $arrivalRecord = ArrivalRecord::where('user_id', $user->id)
            ->whereDate('recorded_at', $date->format('Y-m-d'))
            ->first();

        return $arrivalRecord && $arrivalRecord->arrivalDepartureRecords()->exists();
    }

    private function hasSecondArrivalRecord($user, $date)
    {
        // Check if SecondArrivalRecord exists for the given day
        $secondArrivalRecord = ArrivalRecord::where('user_id', $user->id)
            ->whereDate('second_recorded_at', $date->format('Y-m-d'))
            ->first();

        return $secondArrivalRecord ? true : false;
    }



    public function record_manual(Request $request)
    {

            $data = $request->validate([
                'recorded_at' => ['required', 'date'],
                'button' => ['required', 'string', 'in:ArrivalRecord,DepartureRecord,SecondArrivalRecord,SecondDepartureRecord'],
            ]);

            $inputDate = \Carbon\Carbon::parse($data['recorded_at']);
            $user = $request->user();



            // Check if the user belongs to 'ユメヤ'
            $isYumeya = $user->office && $user->office->corp ? $user->office->corp->corp_name === 'ユメヤ' : false;




            // Logic for handling button clicks

            if ($data['button'] === 'SecondArrivalRecord') {
                // Check if both ArrivalRecord and DepartureRecord exist before allowing SecondArrivalRecord
                if (!$this->hasArrivalAndDepartureRecords($user, $inputDate)) {
                    return redirect()->route('dashboard')->with('error', '先に出勤と退社の記録を入れてください。');
                }
            }

            if ($data['button'] === 'SecondDepartureRecord') {
                // Check if SecondArrivalRecord exists before allowing SecondDepartureRecord
                if (!$this->hasSecondArrivalRecord($user, $inputDate)) {
                    return redirect()->route('dashboard')->with('error', '先に二回出勤の記録を入れてください。');
                }
            }

            // Handle Arrival and Departure records
            if (in_array($data['button'], ['ArrivalRecord', 'SecondArrivalRecord'])) {
                $this->handleArrivalRecord($user, $inputDate, $data['button'], $isYumeya);
            } else {
                $this->handleDepartureRecord($user, $inputDate, $data['button']);
            }

            // Success message
            $message = $this->getSuccessMessage($data['button'], $inputDate);
            return redirect()->route('dashboard')->with('status', $message);


    }


    private function handleArrivalRecord($user, $inputDate, $buttonType, $isYumeya)
    {
        if ($buttonType == 'ArrivalRecord') {
            $inputDate = $this->adjustArrivalTime($inputDate, $isYumeya);
        }

        $columnName = $buttonType === 'ArrivalRecord' ? 'recorded_at' : 'second_recorded_at';

        $exist = ArrivalRecord::where('user_id', $user->id)
            ->whereDate('recorded_at', $inputDate->format('Y-m-d'))
            ->first();

        if ($exist) {
            $exist->update([$columnName => $inputDate]);
        } else {
            $user->userArrivalRecords()->create([
                'recorded_at' => $buttonType === 'ArrivalRecord' ? $inputDate : null,
                'second_recorded_at' => $buttonType === 'SecondArrivalRecord' ? $inputDate : null,
            ]);
        }
    }


    private function handleDepartureRecord($user, $inputDate, $buttonType)
    {
        if($inputDate->hour < 8){
            $inputDate->subDay();
        }

        $exist=ArrivalRecord::where('user_id', $user->id)
                ->whereDate('recorded_at', $inputDate->format('Y-m-d'))
                ->first();

        if($exist)
        {
            $columnName=$buttonType === 'DepartureRecord' ? 'recorded_at' : 'second_recorded_at';

            $departureExist=$exist->arrivalDepartureRecords()->whereDate('recorded_at', $inputDate->format('Y-m-d'))->first();

            if($departureExist){
                $departureExist->update([$columnName=>$inputDate]);
            }else{
                $exist->arrivalDepartureRecords()->create([
                    'recorded_at'=>$buttonType === 'DepartureRecord' ? $inputDate :null,
                    'second_recorded_at'=>$buttonType === 'SecondDepartureRecord' ? $inputDate : null,
                ]);
            }

        }
        else{
            $arrival=$user->userArrivalRecords()->create(['recorded_at'=>$inputDate]);
            $arrival->arrivalDepartureRecords()->create(['recorded_at'=>$inputDate]);

        }
    }

    private function checkIfArrivalAndDepartureExist($user, $date)
{
    $record = ArrivalRecord::where('user_id', $user->id)
        ->whereDate('recorded_at', $date->format('Y-m-d'))
        ->first();

    if ($record && $record->arrivalDepartureRecords()->exists()) {
        return true;
    }

    return false;
}

private function checkIfSecondArrivalExists($user, $date)
{
    $record = ArrivalRecord::where('user_id', $user->id)
        ->whereDate('second_recorded_at', $date->format('Y-m-d'))
        ->first();

    return $record ? true : false;
}



    private function adjustArrivalTime($inputDate, $isYumeya)
    {
        $workStartTime= $inputDate->copy()->setTime($isYumeya ? 9 :8, $isYumeya ? 0 :30, 0);
        $earliestAllowedTime=$workStartTime->copy()->setTime(5,31,0);
        $earlyArrivalCutoff= $workStartTime->copy()->subMinutes(29);
        $sixCheck = $workStartTime->copy()->setTime(6,00,0);
        $sixThirtyCheck=$workStartTime->copy()->setTime(6,30,0);
        $sevenCheck=$workStartTime->copy()->setTime(7,00,0);
        $sevenThirtyCheck=$workStartTime->copy()->setTime(7,30,00);
        $eightCheck=$workStartTime->copy()->setTime(8,00,0);
        $eightThirtyCheck=$workStartTime->copy()->setTime(8,30,0);

        if($inputDate->between($earliestAllowedTime, $sixCheck)){

                return $sixCheck;
            }
            elseif($inputDate->between($sixCheck, $sixThirtyCheck)){
                return $sixThirtyCheck;

            }
            elseif($inputDate->between($sixThirtyCheck, $sevenCheck)){
                return $sevenCheck;

            }
            elseif($inputDate->between($sevenCheck, $sevenThirtyCheck))
            {
                return $sevenThirtyCheck;
            }

            elseif($inputDate->between($sevenThirtyCheck, $eightCheck))
            {
                return $eightCheck;
            }
            elseif($isYumeya && $inputDate->between($eightCheck->addMinute(), $eightThirtyCheck)){
                return $eightThirtyCheck;
            }

        elseif($inputDate->between($earlyArrivalCutoff, $workStartTime)){
            return $workStartTime;

        } elseif ($inputDate->lt($earliestAllowedTime)) {
            return $earliestAllowedTime;
        }

        return $inputDate;
    }


    private function getSuccessMessage($buttonType, $date)
    {
        $messages = [
            'ArrivalRecord' => ['message' => '出勤時間が登録されました。', 'date' => $date],
            'DepartureRecord' => ['message' => '退社時間が登録されました。', 'date' => $date],
            'SecondArrivalRecord' => ['message' => '二回目の出勤時間が登録されました。', 'date' => $date],
            'SecondDepartureRecord' => ['message' => '二回目の退社時間が登録されました。', 'date' => $date]
        ];

        if (!isset($messages[$buttonType])) {
            return '';
        }

        return $messages[$buttonType]['message'] . '<br><span class="text-lg">' . $messages[$buttonType]['date'] . '</span>';
    }







    public function startBreak(Request $request)
    {
        $user = $request->user();
        $startTime = $request->input('recorded_at');

        $this->validate($request, [
            'recorded_at' => 'required|date',
        ]);

        $break = Breaks::where('user_id', $user->id)
            ->whereDate('start_time', \Carbon\Carbon::parse($startTime)->toDateString())
            ->first();



        if (!$break) {
            $break = new Breaks([
                'user_id' => $user->id,
                'start_time' => $startTime,
            ]);
            $break->save();


            return redirect()->route('dashboard')->with('status', "1回目の休憩開始時間が登録されました。$startTime");
        } elseif ($break->end_time && $break->start_time2 === null) {
            $break->start_time2 = $startTime;
            $break->save();
            return redirect()->route('dashboard')->with('status', "2回目の休憩開始時間が登録されました。$startTime");

        } elseif ($break->end_time2 && $break->start_time3 === null) {
            $break->start_time3 = $startTime;
            $break->save();
            return redirect()->route('dashboard')->with('status', "3回目の休憩開始時間が登録されました。$startTime");
        } else {
            return redirect()->route('dashboard')->with('status', '前回の休憩が終了していないか、本日の休憩回数が上限に達しました。');
        }
    }

    public function endBreak(Request $request)
    {
        $user = $request->user();
        $endTime = $request->input('recorded_at');

        $this->validate($request, [
            'recorded_at' => 'required|date',
        ]);

        $break = Breaks::where('user_id', $user->id)
            ->whereDate('start_time', \Carbon\Carbon::parse($endTime)->toDateString())
            ->first();

        if (!$break) {
            return redirect()->route('dashboard')->with('status', '本日の休憩開始記録が見つかりません。');
        }

        if ($break->end_time === null) {
            $break->end_time = $endTime;
            $breakDuration = $this->calculateBreakDuration($break->start_time, $break->end_time);
            $message = "1回目の休憩終了時間が登録されました。$endTime";

        } elseif ($break->end_time2 === null && $break->start_time2 !== null) {
            $break->end_time2 = $endTime;
            $breakDuration = $this->calculateBreakDuration($break->start_time2, $break->end_time2);
            $message = "2回目の休憩終了時間が登録されました。$endTime";

        } elseif ($break->end_time3 === null && $break->start_time3 !== null) {
            $break->end_time3 = $endTime;
            $breakDuration = $this->calculateBreakDuration($break->start_time3, $break->end_time3);
            $message = "3回目の休憩終了時間が登録されました。$endTime";

        } else {
            return redirect()->route('dashboard')->with('status', '全ての休憩が既に終了しています。');
        }

        $break->save();
        return redirect()->route('dashboard')->with('status', $message . ' 休憩時間: ' . $breakDuration . ' 分');
    }

    public function checkBreakStatus(Request $request)
    {
        $user = $request->user();
        $date = $request->query('date');

        $break = Breaks::where('user_id', $user->id)
            ->whereDate('start_time', \Carbon\Carbon::parse($date)->toDateString())
            ->first();

        $status = [
            'canStartBreak' => true,
            'breakCount' => 0,
            'message' => ''
        ];

        if ($break) {
            $status['breakCount'] = 1;

            if ($break->end_time === null) {
                $status['canStartBreak'] = false;
                $status['message'] = '1回目の休憩を終了してください。';
            } elseif ($break->start_time2 !== null) {
                $status['breakCount'] = 2;
                if ($break->end_time2 === null) {
                    $status['canStartBreak'] = false;
                    $status['message'] = '2回目の休憩を終了してください。';
                } elseif ($break->start_time3 !== null) {
                    $status['breakCount'] = 3;
                    if ($break->end_time3 === null) {
                        $status['canStartBreak'] = false;
                        $status['message'] = '3回目の休憩を終了してください。';
                    } else {
                        $status['canStartBreak'] = false;
                        $status['message'] = '本日の休憩回数が上限に達しました。';
                    }
                }
            }
        }

        return response()->json($status);
    }


    private function calculateBreakDuration($startTime, $endTime)
    {
        $startTime = \Carbon\Carbon::parse($startTime);
        $endTime = \Carbon\Carbon::parse($endTime);
        return $startTime->diffInMinutes($endTime);
    }

    public function checkBreakCount(Request $request)
{
    $user = $request->user();
    $date = $request->query('date');

    $break = Breaks::where('user_id', $user->id)
        ->whereDate('start_time', \Carbon\Carbon::parse($date)->toDateString())
        ->first();

    $count = 0;
    if ($break) {
        $count = 1 + ($break->start_time2 !== null ? 1 : 0) + ($break->start_time3 !== null ? 1 : 0);
    }

    return response()->json(['count' => $count]);
}

}

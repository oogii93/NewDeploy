<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\Breaks;
use Illuminate\Http\Request;
use App\Models\ArrivalRecord;
use App\Models\DepartureRecord;
use App\Models\VacationCalendar;
use App\Rules\RecordedAtExistsRule;
use App\Http\Controllers\Controller;
use App\Models\AttendanceTypeRecord;
use App\Models\TimeOffRequestRecord;

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



    // public function record_manual(Request $request)
    // {

    //         $data = $request->validate([
    //             'recorded_at' => ['required', 'date'],
    //             'button' => ['required', 'string', 'in:ArrivalRecord,DepartureRecord,SecondArrivalRecord,SecondDepartureRecord'],
    //         ]);

    //         $inputDate = \Carbon\Carbon::parse($data['recorded_at']);
    //         $user = $request->user();

    //         // if($inputDate->isWeekend()){
    //         //     return redirect()->route('dashboard')->with('error','週末は勤怠記録できません。もし週末に働く必要がある場合はフォームに記入してください');
    //         // }



    //         // Check if the user belongs to 'ユメヤ'
    //         $isYumeya = $user->office && $user->office->corp ? $user->office->corp->corp_name === 'ユメヤ' : false;




    //         // Logic for handling button clicks

    //         if ($data['button'] === 'SecondArrivalRecord') {
    //             // Check if both ArrivalRecord and DepartureRecord exist before allowing SecondArrivalRecord
    //             if (!$this->hasArrivalAndDepartureRecords($user, $inputDate)) {
    //                 return redirect()->route('dashboard')->with('error', '先に出勤と退社の記録を入れてください。');
    //             }
    //         }

    //         if ($data['button'] === 'SecondDepartureRecord') {
    //             // Check if SecondArrivalRecord exists before allowing SecondDepartureRecord
    //             if (!$this->hasSecondArrivalRecord($user, $inputDate)) {
    //                 return redirect()->route('dashboard')->with('error', '先に二回出勤の記録を入れてください。');
    //             }
    //         }

    //         // Handle Arrival and Departure records
    //         if (in_array($data['button'], ['ArrivalRecord', 'SecondArrivalRecord'])) {
    //             $this->handleArrivalRecord($user, $inputDate, $data['button'], $isYumeya);
    //         } else {
    //             $this->handleDepartureRecord($user, $inputDate, $data['button']);
    //         }

    //         // Success message
    //         $message = $this->getSuccessMessage($data['button'], $inputDate);
    //         return redirect()->route('dashboard')->with('status', $message);


    // }



    public function record_manual(Request $request)
    {
        $data = $request->validate([

            'recorded_at' => ['required', 'date'],
            'button' => ['required', 'string', 'in:ArrivalRecord,DepartureRecord,SecondArrivalRecord,SecondDepartureRecord'],
        ]);

        $inputDate = \Carbon\Carbon::parse($data['recorded_at']);
        $user = $request->user();

        $isYumeya = $user->office && $user->office->corp_id ? $user->office->corp->corp_name === 'ユメヤ' : false;

        $timeOffRequest = TimeOffRequestRecord::where('user_id', $user->id)
            ->whereDate('date', $inputDate->format('Y-m-d'))
            ->whereHas('attendanceTypeRecord', function ($query) {
                $query->where('name', '半休');
            })
            ->first();
            // dd($isYumeya);
            // dd($timeOffRequest);


        if ($timeOffRequest) {
            $timeLimit = $isYumeya ? 9 : 8;
            $minuteLimit = $isYumeya ? 0 : 30;



            if ($data['button'] === 'ArrivalRecord') {
                // Set DepartureRecord to 13:00 for Yumeya users, 12:30 otherwise
                if ($inputDate->hour <= $timeLimit && ($inputDate->hour < $timeLimit || $inputDate->minute <= $minuteLimit)) {
                    $this->handleArrivalRecord($user, $inputDate, 'ArrivalRecord', $isYumeya);


                    $departureTime = $inputDate->copy()->setTime(
                        $isYumeya ? 13  : 12,
                        $isYumeya ? 0 :30
                    );

                    $this->handleDepartureRecord($user, $departureTime, 'DepartureRecord');
                    // dd($departureTime);

                return redirect()->route('dashboard')->with('status', '出勤時間と半日退勤時間を記録しました。');

            }elseif($inputDate->hour >12){

                $inputDate->setTime($isYumeya ? 13 : 13, $isYumeya ? 0 : 30);
                $this->handleArrivalRecord($user, $inputDate,'ArrivalRecord', false);

                return redirect()->route('dashboard')->with('success', '午後半日出勤時間を記録しました。');
            }

            else{


                  // Return error if time is after the limit
                  return redirect()->route('dashboard')->with('error', $isYumeya ?
                  '午前半休の場合、出勤時間は9:00までです。' :
                  '午前半休の場合、出勤時間は8:30までです。');
            }
        }


        }

        // Proceed with normal logic if not 半休
        if ($data['button'] === 'SecondArrivalRecord') {
            if (!$this->hasArrivalAndDepartureRecords($user, $inputDate)) {
                return redirect()->route('dashboard')->with('error', '先に出勤と退社の記録を入れてください。');
            }
        }

        if ($data['button'] === 'SecondDepartureRecord') {
            if (!$this->hasSecondArrivalRecord($user, $inputDate)) {
                return redirect()->route('dashboard')->with('error', '先に二回出勤の記録を入れてください。');
            }
        }

        if (in_array($data['button'], ['ArrivalRecord', 'SecondArrivalRecord'])) {
            $this->handleArrivalRecord($user, $inputDate, $data['button'], $isYumeya);
        } else {
            $this->handleDepartureRecord($user, $inputDate, $data['button']);
        }

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
        // Check for half-day time off request
        $timeOffRequest = TimeOffRequestRecord::where('user_id', $user->id)
            ->whereDate('date', $inputDate->format('Y-m-d'))
            ->whereHas('attendanceTypeRecord', function ($query) {
                $query->where('name', '半休');
            })
            ->first();

        // Get arrival record
        $arrivalRecord = ArrivalRecord::where('user_id', $user->id)
            ->whereDate('recorded_at', $inputDate->format('Y-m-d'))
            ->first();

        // Check if user belongs to Yumeya company
        $isYumeya = $user->office && $user->office->corp->corp_name === 'ユメヤ';

        // Handle departure time limits
        if ($timeOffRequest && $arrivalRecord) {
            // Convert recorded_at to Carbon instance
            $arrivalTime = Carbon::parse($arrivalRecord->recorded_at);

            // If arrival is before 11:00 AM
            if ($arrivalTime->format('H:i') <= '11:00') {
                // Set departure time based on company
                if ($isYumeya) {
                    $inputDate->setTime(13, 0); // 13:00 for Yumeya
                } else {
                    $inputDate->setTime(12, 30); // 12:30 for regular companies
                }
            }
        }

        // Adjust date if time is before 8 AM
        if ($inputDate->hour < 8) {
            $inputDate->subDay();
        }

        // Handle existing arrival record
        if ($arrivalRecord) {
            $columnName = $buttonType === 'DepartureRecord' ? 'recorded_at' : 'second_recorded_at';
            $departureExist = $arrivalRecord
                ->arrivalDepartureRecords()
                ->whereDate('recorded_at', $inputDate->format('Y-m-d'))
                ->first();

            if ($departureExist) {
                $departureExist->update([$columnName => $inputDate]);
            } else {
                $arrivalRecord->arrivalDepartureRecords()->create([
                    'recorded_at' => $buttonType === 'DepartureRecord' ? $inputDate : null,
                    'second_recorded_at' => $buttonType === 'SecondDepartureRecord' ? $inputDate : null,
                ]);
            }
        } else {
            // Create new arrival and departure records
            $arrival = $user->userArrivalRecords()->create(['recorded_at' => $inputDate]);
            $arrival->arrivalDepartureRecords()->create(['recorded_at' => $inputDate]);
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
        // Define all time checkpoints
        $workStartTime = $inputDate->copy()->setTime($isYumeya ? 9 : 8, $isYumeya ? 0 : 30, 0);
        $earliestAllowedTime = $workStartTime->copy()->setTime(5, 31, 0);
        $earlyArrivalCutoff = $workStartTime->copy()->subMinutes(29);

        // Create immutable time checks
        $timeChecks = [
            $workStartTime->copy()->setTime(6, 0, 0),  // sixCheck
            $workStartTime->copy()->setTime(6, 30, 0), // sixThirtyCheck
            $workStartTime->copy()->setTime(7, 0, 0),  // sevenCheck
            $workStartTime->copy()->setTime(7, 30, 0), // sevenThirtyCheck
            $workStartTime->copy()->setTime(8, 0, 0),  // eightCheck
            $workStartTime->copy()->setTime(8, 30, 0), // eightThirtyCheck
            $workStartTime->copy()->setTime(9, 0, 0),  // nineCheck
        ];

        // Handle early morning cases first
        if ($inputDate->lt($earliestAllowedTime)) {
            return $earliestAllowedTime;
        }

        // Handle the standard time blocks
        if ($inputDate->between($timeChecks[0], $timeChecks[1])) {
            return $timeChecks[1];  // return 6:30
        }
        if ($inputDate->between($timeChecks[1], $timeChecks[2])) {
            return $timeChecks[2];  // return 7:00
        }
        if ($inputDate->between($timeChecks[2], $timeChecks[3])) {
            return $timeChecks[3];  // return 7:30
        }
        if ($inputDate->between($timeChecks[3], $timeChecks[4])) {
            return $timeChecks[4];  // return 8:00
        }

        // Special handling for Yumeya users after 8:00
        if ($isYumeya) {
            if ($inputDate->between($timeChecks[4], $timeChecks[5])) {
                return $timeChecks[5];  // return 8:30
            }
            if ($inputDate->between($timeChecks[5], $timeChecks[6])) {
                return $timeChecks[6];  // return 9:00
            }
        }

        // Handle the period just before work start time
        if ($inputDate->between($earlyArrivalCutoff, $workStartTime)) {
            return $workStartTime;
        }

        return $inputDate;





        // $sixCheck = $workStartTime->copy()->setTime(6, 00, 0);
        // $sixThirtyCheck = $workStartTime->copy()->setTime(6, 30, 0);
        // $sevenCheck = $workStartTime->copy()->setTime(7, 00, 0);
        // $sevenThirtyCheck = $workStartTime->copy()->setTime(7, 30, 00);
        // $eightCheck = $workStartTime->copy()->setTime(8, 00, 0);
        // $eightThirtyCheck = $workStartTime->copy()->setTime(8, 30, 0);
        // $nineCheck=$workStartTime->copy()->setTime(9, 00,0);

        // if ($inputDate->between($earliestAllowedTime, $sixCheck)) {

        //     return $sixCheck;
        // } elseif ($inputDate->between($sixCheck, $sixThirtyCheck)) {
        //     return $sixThirtyCheck;
        // } elseif ($inputDate->between($sixThirtyCheck, $sevenCheck)) {
        //     return $sevenCheck;
        // } elseif ($inputDate->between($sevenCheck, $sevenThirtyCheck)) {
        //     return $sevenThirtyCheck;
        // } elseif ($inputDate->between($sevenThirtyCheck, $eightCheck)) {
        //     return $eightCheck;
        // } elseif ($isYumeya && $inputDate->between($eightCheck->addMinute(), $eightThirtyCheck)) {
        //     return $eightThirtyCheck;
        // }elseif($isYumeya && $inputDate->between($eightThirtyCheck, $nineCheck)){
        //     return $nineCheck;
        // }

        //  elseif ($inputDate->between($earlyArrivalCutoff, $workStartTime)) {
        //     return $workStartTime;
        // } elseif ($inputDate->lt($earliestAllowedTime)) {
        //     return $earliestAllowedTime;
        // }

        // return $inputDate;
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


    // public function destroy($id)
    // {
    //     try{
    //         $arrivalRecord=ArrivalRecord::findOrFail($id);
    //         //
    //         if(auth()->user()->id !==$arrivalRecord->user_id){
    //             return redirect()->back()->with('error', '権限がありません。');
    //         }
    //            // Begin transaction to ensure all related records are deleted properly
    //            \DB::beginTransaction();

    //         if($arrivalRecord->arrivalDepartureRecords){
    //             $arrivalRecord->arrivalDepartureRecords()->delete();
    //         }

    //         $arrivalRecord->delete();

    //         \DB::commit();

    //         return redirect()->back()->with('status', '記録が削除されました。');



    //     }catch(\Exception $e){
    //         DB::rollBack();

    //         return redirect()->back()->with('error','記録の削除に失敗しました。');
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $arrivalRecord = ArrivalRecord::findOrFail($id);

    //         // Check authorization
    //         if (auth()->user()->id !== $arrivalRecord->user_id) {
    //             return redirect()->back()->with('error', '権限がありません。');
    //         }

    //         $recordDate = $arrivalRecord->arrival_time
    //     ? \Carbon\Carbon::parse($arrivalRecord->arrival_time)->format('Y-m-d')
    //     : \Carbon\Carbon::parse($arrivalRecord->created_at)->format('Y-m-d');

    // // dd([
    // //     'arrival_record' => [
    // //         'id' => $arrivalRecord->id,
    // //         'arrival_time' => $arrivalRecord->arrival_time,
    // //         'created_at' => $arrivalRecord->created_at,
    // //         'user_id' => $arrivalRecord->user_id
    // //     ],
    // //     'record_date' => $recordDate,
    // //     'breaks' => Breaks::where('user_id', $arrivalRecord->user_id)
    // //         ->where(function($query) use ($recordDate) {
    // //             $query->whereDate('start_time', $recordDate)
    // //                   ->orWhereDate('created_at', $recordDate);
    // //         })
    // //         ->get()
    // //         ->map(function($break) {
    // //             return [
    // //                 'id' => $break->id,
    // //                 'start_time' => $break->start_time,
    // //                 'created_at' => $break->created_at
    // //             ];
    // //         })
    // // ]);

    //         // Begin transaction
    //         \DB::beginTransaction();

    //         // Get the date - use created_at if arrival_time is null
    //         $recordDate = $arrivalRecord->arrival_time
    //             ? \Carbon\Carbon::parse($arrivalRecord->arrival_time)->format('Y-m-d')
    //             : \Carbon\Carbon::parse($arrivalRecord->created_at)->format('Y-m-d');

    //         // Delete breaks matching either start_time date or created_at date
    //         $breaks = Breaks::where('user_id', $arrivalRecord->user_id)
    //             ->where(function($query) use ($recordDate) {
    //                 $query->whereDate('start_time', $recordDate)
    //                       ->orWhereDate('created_at', $recordDate);
    //             })
    //             ->delete();

    //         // Log what's being deleted
    //         \Log::info('Deleting records:', [
    //             'user_id' => $arrivalRecord->user_id,
    //             'date' => $recordDate,
    //             'arrival_id' => $id,
    //             'breaks_deleted' => $breaks
    //         ]);

    //         // Delete arrival departure records
    //         $arrivalRecord->arrivalDepartureRecords()->delete();

    //         // Delete the arrival record
    //         $arrivalRecord->delete();

    //         \DB::commit();

    //         return redirect()->back()->with('status', '記録と関連する記録が削除されました。');

    //     } catch (\Exception $e) {
    //         \DB::rollBack();
    //         \Log::error('Delete error:', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return redirect()->back()->with('error', '記録の削除に失敗しました。');
    //     }
    // }

    public function destroy($id)
    {
        try {
            $arrivalRecord = ArrivalRecord::findOrFail($id);

            // Authorization check
            if (auth()->user()->id !== $arrivalRecord->user_id) {
                return redirect()->back()->with('error', '権限がありません。');
            }

            // Begin transaction
            \DB::beginTransaction();

            // Get arrival and departure times
            $arrivalTime = $arrivalRecord->arrival_time
                ? Carbon::parse($arrivalRecord->arrival_time)
                : Carbon::parse($arrivalRecord->created_at);

            $departureTime = $arrivalRecord->arrivalDepartureRecords->first()
                ? Carbon::parse($arrivalRecord->arrivalDepartureRecords->first()->recorded_at)
                : $arrivalTime->copy()->endOfDay();

            // Delete only breaks that fall within this arrival-departure period
            $breaks = Breaks::where('user_id', $arrivalRecord->user_id)
                ->where(function ($query) use ($arrivalTime, $departureTime) {
                    $query->whereBetween('start_time', [$arrivalTime, $departureTime])
                        ->orWhereBetween('end_time', [$arrivalTime, $departureTime])
                        ->orWhere(function ($q) use ($arrivalTime, $departureTime) {
                            $q->where('start_time', '<=', $arrivalTime)
                                ->where('end_time', '>=', $departureTime);
                        });
                })
                ->delete();

            // Log the deletion details
            \Log::info('Deleting specific records:', [
                'user_id' => $arrivalRecord->user_id,
                'arrival_time' => $arrivalTime,
                'departure_time' => $departureTime,
                'arrival_id' => $id,
                'breaks_deleted' => $breaks
            ]);

            // Delete arrival departure records
            $arrivalRecord->arrivalDepartureRecords()->delete();

            // Delete the arrival record
            $arrivalRecord->delete();

            \DB::commit();

            return redirect()->back()->with('status', '記録と関連する記録が削除されました。');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Delete error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', '記録の削除に失敗しました。');
        }
    }



    public function validatePeriod()
    {
        $user = auth()->user();

        // Reuse the calculated date range from the index() method
        $year = date('Y');
        $month = date('m');
        $givenDate = Carbon::parse("$year-$month-16");

        if (Carbon::today()->day < 16) {
            $startDate = $givenDate->copy()->subMonth()->startOfDay();
            $endDate = $givenDate->copy()->subDay()->endOfDay();
        } else {
            $startDate = $givenDate->copy()->startOfDay();
            $endDate = $givenDate->copy()->addMonth()->subDay()->endOfDay();
        }

        // \Log::info("Start Date: $startDate, End Date: $endDate");

        $holidayDates=VacationCalendar::whereBetween('vacation_date',[
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d')
        ])
        ->pluck('vacation_date')
        ->map(function($date){
            return Carbon::parse($date)->format('Y-m-d');
        })
        ->toArray();
        // dump($holidayDates);

        // Fetch records within the calculated range
        $attendanceRecords = ArrivalRecord::where('user_id', $user->id)
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->with('arrivalDepartureRecords')
            ->get();

        $timeOffRecords = TimeOffRequestRecord::where('user_id', $user->id)
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        $issues = [];
        $warnings = [];
        $currentDate = $startDate->copy();
        $firstCheckMethod = null;


            // if ($currentDate->isWeekend()) {
            //     $holidayWork = $timeOffRecords->first(function ($record) use ($currentDate) {
            //         return $record->date == $currentDate->format('Y-m-d') &&
            //             $record->attendance_type_records_id == AttendanceTypeRecord::where('name', '休日出勤')->first()->id;
            //     });

            while ($currentDate <= $endDate) {
                $currentDateStr = $currentDate->format('Y-m-d');

                // Skip if it's a holiday (unless there's holiday work scheduled)
                if (in_array($currentDateStr, $holidayDates)) {
                    $holidayWork = $timeOffRecords->first(function ($record) use ($currentDate) {
                        return $record->date == $currentDate->format('Y-m-d') &&
                            $record->attendance_type_records_id == AttendanceTypeRecord::where('name', '休日出勤')->first()->id;
                    });

                    if (!$holidayWork) {
                        $currentDate->addDay();
                        continue;
                    }
                }


            $dayAttendance = $attendanceRecords->first(fn($record) => Carbon::parse($record->recorded_at)->isSameDay($currentDate));
            $dayTimeOff = $timeOffRecords->first(fn($record) => $record->date == $currentDate->format('Y-m-d'));
            $displayDate = $currentDate->format('n/j');

            if (!$dayAttendance && !$dayTimeOff) {
                $issues[] = "{$displayDate}: 出勤記録または休暇申請がありません";
            }

            // if ($dayTimeOff && !in_array($dayTimeOff->status, ['approved', 'denied','pending'])) {
            //     $warnings[] = "{$displayDate}: 休暇申請が承認待ち状態です";
            // }
            if ($dayTimeOff) {
                if ($dayTimeOff->status === 'pending') {
                    $issues[] = "{$displayDate}:休暇申請が承認待ちです ";
                } elseif (!in_array($dayTimeOff->status, ['approved', 'denied'])) {
                    $issues[] = "{$displayDate}: 休暇申請の状態が無効です";
                }
            }

            if ($dayAttendance) {
                $arrivalTime = Carbon::parse($dayAttendance->recorded_at);

                $currentCheckMethod = $dayAttendance->check_in_method;
                if ($firstCheckMethod === null && $currentCheckMethod) {
                    $firstCheckMethod = $currentCheckMethod;
                } elseif ($firstCheckMethod && $currentCheckMethod && $firstCheckMethod !== $currentCheckMethod) {
                    $issues[] = "{$displayDate}: 打刻方法が統一されていません";
                }

                if (!$dayAttendance->arrivalDepartureRecords->count()) {
                    $issues[] = "{$displayDate}: 退社時間が記録されていません";
                } else {
                    $departureTime = Carbon::parse($dayAttendance->arrivalDepartureRecords->first()->recorded_at);
                    if ($departureTime->lt($arrivalTime)) {
                        $issues[] = "{$displayDate}: 退社時間が出勤時間より前になっています";
                    } elseif ($departureTime->eq($arrivalTime)) {
                        $warnings[] = "{$displayDate}: 出勤時間と退社時間が同じです";
                    }
                }
            }

            $currentDate->addDay();
        }

        return response()->json([
            'isValid' => empty($issues),
            'issues' => $issues,
            'warnings' => $warnings,
            'periodStart' => $startDate->format('Y/m/d'),
            'periodEnd' => $endDate->format('Y/m/d'),
            'holidayDates'=>$holidayDates
        ]);
    }
}

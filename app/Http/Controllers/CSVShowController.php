<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Corp;
use App\Models\User;
use App\Models\Office;
use App\Models\Calculation;
use App\Models\CheckboxData;
use Illuminate\Http\Request;
use App\Models\ArrivalRecord;
use App\Models\VacationCalendar;
use App\Models\WeekendCheckList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;

class CSVShowController extends Controller
{





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
            // dd($offices); // Add this line to inspect the data
        } else {
            $offices = Office::all();
        }


        return view('admin.csv.show', compact('corps', 'offices', 'selectedCorpId', 'selectedYear', 'selectedMonth','calculations'));
    }



    public function filter(Request $request)
    {
          // Fetch users based on the selected corp and office
          $corpId = $request->input('corps_id');
          $officeId = $request->input('office_id');
          $selectedYear = $request->input('year', date('Y'));
          $selectedMonth = $request->input('month', date('n'));
          $users = User::query();


          $corp = Corp::find($corpId);
        $corpName = $corp ? $corp->corp_name : null;

          if ($corpId) {
              $users->whereHas('office', function ($query) use ($corpId) {
                  $query->where('corp_id', $corpId);
              });
          }

          if ($officeId) {
              $users->where('office_id', $officeId);
          }

          $startDate=Carbon::create($selectedYear, $selectedMonth, 16)->subMonth();
          $endDate=Carbon::create($selectedYear, $selectedMonth, 15);



          $users->with([
            'userArrivalRecords' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('recorded_at', [$startDate, $endDate]);
            },
            'userArrivalRecords.arrivalDepartureRecords' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('recorded_at', [$startDate, $endDate]);
            },
            'timeOffRequestRecords' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }

        ]);

        $users = $users->paginate(4);

        $breakData = [];
        foreach ($users as $user) {
            $breakData[$user->id] = calculateTotalBreakMinutes($user->id, $startDate, $endDate);
        }
        // dd($breakData);

        $holidays=VacationCalendar::getHolidaysForRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $officeId);




          $year = date('Y');
          $month = date('m');
          // dd($startDate,$endDate);

          return view('admin.csv.filter', compact('users', 'selectedYear', 'selectedMonth', 'corpId', 'officeId', 'startDate', 'endDate','breakData', 'holidays','corpName'));
      }

      public function saveCheckboxData(Request $request)
      {
          try {
              // Log request data for debugging
              \Log::info('Request Data:', $request->all());

              // Validate the incoming data
              $data = $request->validate([
                  'user_id' => 'required|integer|exists:users,id',
                  'date' => 'required|date',
                  'is_checked' => 'required|boolean',
                  'arrival_recorded_at' => 'nullable|date_format:H:i',
                  'departure_recorded_at' => 'nullable|date_format:H:i'
              ]);

              $arrivalRecord=ArrivalRecord::where('user_id', $data['user_id'])
                    ->whereDate('recorded_at', $data['date'])
                    ->first();

              // Prepare data for checkbox record
              $checkboxData = [
                  'user_id' => $data['user_id'],
                  'date' => $data['date'],
                  'is_checked' => true,
              ];

              // Add arrival and departure times with original record dates
        if (!empty($data['arrival_recorded_at']) && $arrivalRecord) {
            // Combine the original record's date with the extracted time
            $arrivalDateTime = \Carbon\Carbon::parse($arrivalRecord->recorded_at)->format('Y-m-d') . ' ' . $data['arrival_recorded_at'];
            $checkboxData['arrival_recorded_at'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $arrivalDateTime);
        }

        // Find the departure record
        $departureRecord = $arrivalRecord ?
            $arrivalRecord->arrivalDepartureRecords()->first() :
            null;

        if (!empty($data['departure_recorded_at']) && $departureRecord) {
            // Combine the original record's date with the extracted time
            $departureDateTime = \Carbon\Carbon::parse($departureRecord->recorded_at)->format('Y-m-d') . ' ' . $data['departure_recorded_at'];
            $checkboxData['departure_recorded_at'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $departureDateTime);
        }

              // Create or update the checkbox data
              $checklist = CheckboxData::updateOrCreate(
                  [
                      'user_id' => $data['user_id'],
                      'date' => $data['date']
                  ],
                  $checkboxData
              );

              return response()->json([
                  'message' => 'Checkbox data saved successfully',
                  'data' => $checklist
              ]);
          } catch (\Exception $e) {
              \Log::error('Error saving checkbox data:', ['error' => $e->getMessage()]);
              return response()->json(['message' => 'Internal Server Error'], 500);
          }
      }
      public function uncheckData(Request $request)
      {
        try{
            $data=$request->validate([
                'user_id'=>'required|integer|exists:users,id',
                'date'=>'required|date'
            ]);
            $checklist=CheckboxData::where('user_id', $data['user_id'])
                    ->where('date', $data['date'])
                    ->first();


                    if($checklist){
                        $checklist->delete();



                        return response()->json([
                            'message'=>'Checkbox deleted  successfully',
                         'status'=>'deleted'
                        ]);
                    }


                    return response()->json(['message'=>'no record'], 404);
                } catch (\Exception $e) {
                    \Log::error('Error deleting  data:', ['error' => $e->getMessage()]);
                    return response()->json(['message' => 'Internal Server Error'], 500);
                }
        }

        public function updateTimeRecord(Request $request)
        {
            \Log::info('Updating time record:', $request->all());

            try {
                $data = $request->validate([
                    'user_id' => ['required', 'exists:users,id'],
                    'date' => ['required', 'date'],
                    'time' => ['required'],
                    'type' => ['required', 'string', 'in:ArrivalRecord,DepartureRecord,SecondArrivalRecord,SecondDepartureRecord'],
                ]);

                $user = User::findOrFail($data['user_id']);
                $inputDate = Carbon::parse($data['date'] . ' ' . $data['time']);

                DB::beginTransaction();

                try {
                    $result = null;
                    if (in_array($data['type'], ['ArrivalRecord', 'SecondArrivalRecord'])) {
                        $result = $this->handleArrivalRecord($user, $inputDate, $data['type'], false);
                    } else {
                        $result = $this->handleDepartureRecord($user, $inputDate, $data['type']);
                    }

                    DB::commit();

                    \Log::info('Time record updated successfully');
                    return response()->json(['success' => true, 'data' => $result]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }

            } catch (ValidationException $e) {
                \Log::error('Validation error: ' . json_encode($e->errors()));
                return response()->json([
                    'success' => false,
                    'error' => '入力データが無効です。',
                    'errors' => $e->errors()
                ], 422);

            } catch (\Exception $e) {
                \Log::error('Error updating time record: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                return response()->json([
                    'success' => false,
                    'error' => 'システムエラーが発生しました。'
                ], 500);
            }
        }

   public function deleteTimeRecord(Request $request)


   {
        \Log::info('Delelte time record', $request->all());

            try{
                DB::beginTransaction();

                $data=$request->validate([
                    'user_id'=>['required', 'exists:users,id'],
                    'date'=>['required','date'],
                    'type' => ['required', 'string', 'in:ArrivalRecord,DepartureRecord,SecondArrivalRecord,SecondDepartureRecord'],
                ]);

                $user=User::findOrFail($data['user_id']);
                $date=Carbon::parse($data['date']);

                $record=ArrivalRecord::where('user_id', $user->id)
                        ->whereDate('recorded_at', $date->format('Y-m-d'))
                        ->first();

                        if ($record) {
                            if (in_array($data['type'], ['ArrivalRecord', 'SecondArrivalRecord'])) {
                                // Delete the entire arrival record
                                $record->delete();
                            } else {
                                if ($departureRecord = $record->arrivalDepartureRecords->first()) {
                                    // Delete the departure record
                                    $departureRecord->delete();
                                }
                            }
                        }




                        DB::commit();
                        \Log::info('Time record deleted successfully');
                        return response()->json(['success' => true]);

                    } catch (\Exception $e) {
                        DB::rollBack();
                        \Log::error('Error deleting time record: ' . $e->getMessage());
                        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
                    }
                }


        private function handleArrivalRecord($user, $inputDate, $buttonType, $isYumeya)
        {
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
            if ($inputDate->hour < 8) {
                $inputDate->subDay();
            }

            $exist = ArrivalRecord::where('user_id', $user->id)
                ->whereDate('recorded_at', $inputDate->format('Y-m-d'))
                ->first();

            if ($exist) {
                $columnName = $buttonType === 'DepartureRecord' ? 'recorded_at' : 'second_recorded_at';

                $departureExist = $exist->arrivalDepartureRecords()
                    ->whereDate('recorded_at', $inputDate->format('Y-m-d'))
                    ->first();

                if ($departureExist) {
                    $departureExist->update([$columnName => $inputDate]);
                } else {
                    $exist->arrivalDepartureRecords()->create([
                        'recorded_at' => $buttonType === 'DepartureRecord' ? $inputDate : null,
                        'second_recorded_at' => $buttonType === 'SecondDepartureRecord' ? $inputDate : null,
                    ]);
                }
            } else {
                $arrival = $user->userArrivalRecords()->create(['recorded_at' => $inputDate]);
                $arrival->arrivalDepartureRecords()->create(['recorded_at' => $inputDate]);
            }
        }

























}

<?php

namespace App\Http\Controllers;

use App\Models\ArrivalRecord;
use Carbon\Carbon;
use App\Models\Corp;
use App\Models\User;
use App\Models\Office;
use App\Models\Calculation;
use App\Models\CheckboxData;
use Illuminate\Http\Request;
use App\Models\VacationCalendar;
use App\Models\WeekendCheckList;
use Illuminate\Support\Facades\Validator;

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




















}

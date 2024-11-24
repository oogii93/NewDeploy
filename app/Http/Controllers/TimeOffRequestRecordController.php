<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Notifications\TimeOffRequestHumanResourcedNotification;
use Illuminate\Http\Request;
use App\Models\AttendanceTypeRecord;
use App\Models\TimeOffRequestRecord;
use App\Notifications\TimeOffRequestCreatedNotification;
use App\Notifications\TimeOffRequestStatusChangedNotification;

class TimeOffRequestRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */




    public function checkApplication(TimeOffRequestRecord $timeOffRequestRecord, Request $request)
    {
        $isChecked = $request->input('is_checked');

        if ($isChecked && !$timeOffRequestRecord->is_checked) {
            $timeOffRequestRecord->update([
                'is_checked' => true,
                'checked_by' => auth()->id(),
                'checked_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'checked_by' => auth()->user()->name,
                'checked_at' => now()->format('Y-m-d H:i'),
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function index()
    {
        $timeOffRequestRecords = TimeOffRequestRecord::with(['user', 'attendanceTypeRecord'])->get();

        return view('admin.time_off.index', compact('timeOffRequestRecords'));
    }


    public function index2()
    {
        $timeOffRequestRecords = TimeOffRequestRecord::with(['user', 'attendanceTypeRecord'])
            ->where('boss_id', auth()->id()) //wow end newtersen hereglegchiin id === boss_id zaaj baina
            ->get();

        $divisions = Division::whereIn('name', ['人事課', '経理課'])->get();

        return view('time_off_boss.index', compact('timeOffRequestRecords', 'divisions'));
    }


    public function updateStatus(Request $request, $id)
    {
        $timeOffRequest = TimeOffRequestRecord::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|in:approved,denied',
            'division_id' => 'required_if:status,approved|exists:divisions,id',
        ]);

        $timeOffRequest->status = $validatedData['status'];

        if ($validatedData['status'] === 'approved') {
            $timeOffRequest->division_id = $validatedData['division_id'];



            if($timeOffRequest->attendanceTypeRecord->name==='休日出勤')
            {
              $timeOffRequest->is_checked=true;
              $timeOffRequest->checked_by=auth()->id();
            //   $timeOffRequest->checked_at();
            }

            //Notify HR users if approved
            if($validatedData['division_id'] ==6){
                $hrUsers=User::where('division_id', 6)->get();

                foreach($hrUsers as $hrUser){
                    $hrUser->notify(new TimeOffRequestHumanResourcedNotification($timeOffRequest));
                }
            }
        }

        $timeOffRequest->save();

           // Notify the user about the status change
        $timeOffRequest->user->notify(new TimeOffRequestStatusChangedNotification($timeOffRequest));


        $message = $validatedData['status'] === 'approved'
            ? '勤怠届が承認されました。'
            : '勤怠届が拒否されました。';

        return redirect()->route('time_off_boss.index')->with('success', $message);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $attendanceTypeRecords = AttendanceTypeRecord::all();
        return view('admin.time_off.create', compact('users', 'attendanceTypeRecords'));
    }




    public function store(Request $request)
    {
        $validationRules = [
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'attendance_type_records_id' => 'required|exists:attendance_type_records,id',
            'reason_select' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255',
            'boss_id' => 'nullable|exists:users,id',
        ];

        $validatedData = $request->validate($validationRules);

        // Set default values
        $validatedData['status'] = 'pending';
        $validatedData['is_checked'] = false;
        $validatedData['is_first_approval'] = false;

        // Create and save the TimeOffRequestRecord
        $timeOffRequest = TimeOffRequestRecord::create($validatedData);


           // Notify the boss
    if ($timeOffRequest->boss_id) {
        $boss = User::find($timeOffRequest->boss_id);
        $boss->notify(new TimeOffRequestCreatedNotification($timeOffRequest));
    }



        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '勤怠届が正常に登録されました。'
            ]);
        }
        // dd($request->all());

        return redirect()->back()->with('success', '勤怠届が正常に登録されました。');
    }

    public function store2(Request $request)
    {
        $validationRules=[
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'attendance_type_records_id' => 'required|exists:attendance_type_records,id',
            'reason' => 'nullable|string|max:255',
            'date2' => 'required|date',
            'boss_id' => 'nullable|exists:users,id',
        ];

        $validatedData = $request->validate($validationRules);

        // Set default values
        $validatedData['status'] = 'pending';
        $validatedData['is_checked'] = false;
        $validatedData['is_first_approval'] = false;

        // Create and save the TimeOffRequestRecord
        $timeOffRequest = TimeOffRequestRecord::create($validatedData);


           // Notify the boss
    if ($timeOffRequest->boss_id) {
        $boss = User::find($timeOffRequest->boss_id);
        $boss->notify(new TimeOffRequestCreatedNotification($timeOffRequest));
    }



        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '勤怠届が正常に登録されました。'
            ]);
        }
        // dd($request->all());

        return redirect()->back()->with('success', '勤怠届が正常に登録されました。');


    }










    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeOffRequestRecord $attendanceTypeRecord)
    {
        $users = User::all();
        $attendanceTypeRecords = AttendanceTypeRecord::all();
        return view('admin.time_off.edit', compact('attendanceTypeRecord', 'users', 'attendanceTypeRecords'));
    }


    public function update(Request $request, TimeOffRequestRecord $timeOffRequestRecord)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'attendance_type_records_id' => 'required|exists:attendance_type_records,id',
            'date' => 'required|date',
            'reason_select' => 'nullable|string',
            'reason' => 'nullable|string',
            'boss_id' => 'required|exists:users,id',
        ]);

        $timeOffRequestRecord->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => '勤怠届が正常に更新されました。'
        ]);
    }




    public function destroy(TimeOffRequestRecord $timeOffRequestRecord)
    {
        $timeOffRequestRecord->delete();

        return response()->json([
            'success' => true,
            'message' => '勤怠届が正常に消去されました。'
        ]);
    }
}

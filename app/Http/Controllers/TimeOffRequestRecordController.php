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

            if($timeOffRequestRecord->division_id ==6 || $timeOffRequestRecord->division_id == 9)
            {
                $updateData=['hr_checked'=>true];
            }

            $timeOffRequestRecord->update($updateData);

            return response()->json([
                'success' => true,
                'checked_by' => auth()->user()->name,
                'checked_at' => now()->format('Y-m-d H:i'),
                'hr_checked' => $timeOffRequestRecord->hr_checked,
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function index()
    {
        $timeOffRequestRecords = TimeOffRequestRecord::with(['user', 'attendanceTypeRecord'])->get();

        return view('admin.time_off.index', compact('timeOffRequestRecords'));
    }


    public function index2(Request $request)
    {
        $searchQuery = $request->input('search');

        $query = TimeOffRequestRecord::with(['user', 'attendanceTypeRecord'])
            ->where('boss_id', auth()->id());

        // Add comprehensive search conditions
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                // Search by user name
                $q->whereHas('user', function($userQuery) use ($searchQuery) {
                    $userQuery->where('name', 'like', "%{$searchQuery}%");
                })
                // Search by status
                ->orWhere('status', 'like', "%{$searchQuery}%")

                // Search by reason
                ->orWhere('reason', 'like', "%{$searchQuery}%")

                // Search by reason_select
                ->orWhere('reason_select', 'like', "%{$searchQuery}%")

                // Search by date (allowing different date formats)
                ->orWhere('date', 'like', "%{$searchQuery}%")

                // Search by attendance type name
                ->orWhereHas('attendanceTypeRecord', function($attendanceQuery) use ($searchQuery) {
                    $attendanceQuery->where('name', 'like', "%{$searchQuery}%");
                });
            });
        }

        $timeOffRequestRecords = $query->paginate(20);
        $divisions = Division::whereIn('name', ['人事課'])->get();

        return view('time_off_boss.index', compact('timeOffRequestRecords', 'divisions', 'searchQuery'));
    }

//     public function updateStatus(Request $request, $id)
// {


//     $timeOffRequest = TimeOffRequestRecord::findOrFail($id);

//     $validatedData = $request->validate([
//         'status' => 'required|in:approved,denied',
//         'division_id' => 'required_if:status,approved|exists:divisions,id',
//     ]);

// $timeOffRequest->status=$validatedData['status'];

//     if ($validatedData['status'] === 'approved') {
//         $timeOffRequest->status = $validatedData['status'];
//         $timeOffRequest->division_id = $validatedData['division_id'];



//         if($validatedData['division_id'] == 6) {
//             $timeOffRequest->hr_checked = false;



//             $hrUsers = User::where('division_id', 6)->get();

//         }

//         if($timeOffRequest->attendanceTypeRecord->name === '休日出勤') {
//             $timeOffRequest->is_checked = true;
//             $timeOffRequest->checked_by = auth()->id();
//         }
//         else{
//             $timeOffRequest->division_id=null;
//         }
//     }

//     $timeOffRequest->save();



//     // Add this temporary check right after saving
//     $verifyRecord = TimeOffRequestRecord::find($id);


//     // Before returning, let's check if there are any unchecked notifications
//     $uncheckedCount = TimeOffRequestRecord::uncheckedHrNotifications()->count();
//     //   Notify the user about the status change


//         $timeOffRequest->user->notify(new TimeOffRequestStatusChangedNotification($timeOffRequest));


//         $message = $validatedData['status'] === 'approved'
//             ? '勤怠届が承認されました。'
//             : '勤怠届が拒否されました。';

//         return redirect()->route('time_off_boss.index')->with('success', $message);


//     // Rest of your code...
// }


public function updateStatus(Request $request, $id)
{
    $timeOffRequest = TimeOffRequestRecord::findOrFail($id);

    $validatedData = $request->validate([
        'status' => 'required|in:approved,denied',
        'division_id' => 'required_if:status,approved|exists:divisions,id',
    ]);

    // First, update the basic status
    $timeOffRequest->status = $validatedData['status'];

    if ($validatedData['status'] === 'approved') {
        // Store the HR division ID (assuming it's 6)
        $hrDivisionId = 6;

        // If the selected division is HR
        if ($validatedData['division_id'] == $hrDivisionId) {
            $timeOffRequest->division_id = $hrDivisionId;
            $timeOffRequest->hr_checked = false; // Marking as not checked by HR yet

            // Get HR users for notification
            $hrUsers = User::where('division_id', $hrDivisionId)->get();

            // Notify HR users
            foreach ($hrUsers as $hrUser) {
                $hrUser->notify(new TimeOffRequestHumanResourcedNotification($timeOffRequest));
            }
        }

        // Special handling for holiday work
        if ($timeOffRequest->attendanceTypeRecord->name === '休日出勤') {
            $timeOffRequest->is_checked = true;
            $timeOffRequest->checked_by = auth()->id();
        }
    } else {
        // If denied, clear the division assignment
        $timeOffRequest->division_id = null;
    }

    // Save the changes
    $timeOffRequest->save();

    // Verify the save was successful
    $verifyRecord = TimeOffRequestRecord::find($id);
    if (!$verifyRecord || $verifyRecord->status !== $validatedData['status']) {
        return redirect()->route('time_off_boss.index')->with('error', '更新に失敗しました。');
    }

    // Update unchecked notifications count
    $uncheckedCount = TimeOffRequestRecord::uncheckedHrNotifications()->count();

    // Notify the requesting user
    $timeOffRequest->user->notify(new TimeOffRequestStatusChangedNotification($timeOffRequest));

    $message = $validatedData['status'] === 'approved'
        ? '勤怠届が承認されました。'
        : '勤怠届が拒否されました。';

    return redirect()->route('time_off_boss.index')->with('success', $message);
}


    // public function updateStatus(Request $request, $id)
    // {



    //     $timeOffRequest = TimeOffRequestRecord::findOrFail($id);

    //     $validatedData = $request->validate([
    //         'status' => 'required|in:approved,denied',
    //         'division_id' => 'required_if:status,approved|exists:divisions,id',
    //     ]);

    //     $timeOffRequest->status = $validatedData['status'];


    //     if ($validatedData['status'] === 'approved') {
    //         $timeOffRequest->division_id = $validatedData['division_id'];



    //         if($timeOffRequest->attendanceTypeRecord->name==='休日出勤')
    //         {
    //           $timeOffRequest->is_checked=true;
    //           $timeOffRequest->checked_by=auth()->id();
    //         //   $timeOffRequest->checked_at();
    //         }

    //         if($validatedData['division_id'] == [6,9]) {
    //             $timeOffRequest->hr_checked = false;

    //             \Log::info('Before setting HR checked', [
    //                 'request_id' => $timeOffRequest->id,
    //                 'current_hr_checked' => $timeOffRequest->hr_checked,
    //                 'division_id' => $validatedData['division_id']
    //             ]);

    //             $hrUsers = User::where('division_id', 6)->get();
    //             foreach($hrUsers as $hrUser) {
    //                 $hrUser->notify(new TimeOffRequestHumanResourcedNotification($timeOffRequest));
    //             }
    //         }






    //         //Notify HR users if approved
    //         if($validatedData['division_id'] ==6){
    //             $hrUsers=User::where('division_id', 6)->get();

    //             foreach($hrUsers as $hrUser){
    //                 $hrUser->notify(new TimeOffRequestHumanResourcedNotification($timeOffRequest));
    //             }
    //         }
    //     }

    //     $timeOffRequest->save();

    //        // Notify the user about the status change
    //     $timeOffRequest->user->notify(new TimeOffRequestStatusChangedNotification($timeOffRequest));


    //     $message = $validatedData['status'] === 'approved'
    //         ? '勤怠届が承認されました。'
    //         : '勤怠届が拒否されました。';

    //     return redirect()->route('time_off_boss.index')->with('success', $message);
    // }




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

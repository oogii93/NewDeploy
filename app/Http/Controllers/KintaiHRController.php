<?php

namespace App\Http\Controllers;

use App\Models\TimeOffRequestRecord;

use Illuminate\Http\Request;

class KintaiHRController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'taisei']);
    }

    // public function index()
    // {

    //     $hrDivisionId = 6;
    //     //relationshipvvdiig gargaj baina usertei relationship baigga bol
    //         $query=TimeOffRequestRecord::with(['user', 'user.office', 'user.office.corp'])
    //         ->where('division_id', $hrDivisionId);

    //         $records=$query->paginate(10);



    //         return view('Kintaihr', compact('records'));
    // }


    public function index(Request $request)
    {
        $hrDivisionIds = [6, 9];
        $query = TimeOffRequestRecord::with(['user', 'user.office', 'user.office.corp', 'attendanceTypeRecord', 'boss']);

        $query->where('division_id', $hrDivisionIds);

        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');

            // Search across multiple fields
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%'); // Search by user name
                })
                    ->orWhereHas('user.office', function ($q) use ($search) {
                        $q->where('office_name', 'like', '%' . $search . '%'); // Search by office name
                    })
                    ->orWhereHas('user.office.corp', function ($q) use ($search) {
                        $q->where('corp_name', 'like', '%' . $search . '%'); // Search by company (corp) name
                    })
                    ->orWhere('date', 'like', '%' . $search . '%') // Search by date
                    ->orWhere('reason', 'like', '%' . $search . '%') // Search by reason
                    ->orWhere('reason_select', 'like', '%' . $search . '%') // Search by reason_select
                    ->orWhereHas('attendanceTypeRecord', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%'); // Search by attendance type
                    })
                    ->orWhereHas('boss', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%'); // Search by boss name
                    })
                    ->orWhere('created_at', 'like', '%' . $search . '%'); // Search by status
            });
        }

        $records = $query->latest()->paginate(15);


        if(auth()->user()->division_id== [6,9]){
            TimeOffRequestRecord::uncheckedHrNotifications()
            ->update(['hr_checked' => true, 'hr_checked_by' => auth()->id(), 'hr_checked_at' => now()]);
        }

        return view('Kintaihr', compact('records'));
    }



}

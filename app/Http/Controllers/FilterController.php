<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Corp;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    //admin admin admin
    public function show(Request $request)
    {
        $corps = Corp::get();
        $offices = collect();
        $selectedCorpId = $request->input('corps_id');
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('n'));

        if ($selectedCorpId) {
            $offices = Office::where('corp_id', $selectedCorpId)->get();
            // dd($offices); // Add this line to inspect the data
        } else {
            $offices = Office::all();
        }

        return view('admin.show', compact('corps', 'offices', 'selectedCorpId', 'selectedYear', 'selectedMonth'));
    }



    public function filter(Request $request)
    {
        // Fetch users based on the selected corp and office
        $corpId = $request->input('corps_id');
        $officeId = $request->input('office_id');
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('n'));
        $users = User::query();

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



        $users = $users->get();
        // $users = $users->paginate(3);

        $year = date('Y');
        $month = date('m');
        // dd($startDate,$endDate);

        return view('admin.csv.filter', compact('users', 'selectedYear', 'selectedMonth', 'corpId', 'officeId', 'startDate', 'endDate'));
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Corp;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\VacationCalendar;

class UserFilterController extends Controller

{


    public function index(Request $request)
    {
        $corps = Corp::get();
        $offices = collect();
        $selectedCorpId = $request->input('corps_id');
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('n'));

        // Retrieve offices based on the selected corporation ID
        if ($selectedCorpId) {
            $offices = Office::where('corp_id', $selectedCorpId)->get();
        } else {
            $offices = Office::all();
        }

        // Fetch all users without any filters
        $users = User::with('office')->get();

        // Paginate the results
        $users = $users->all();

        return view('other', compact('corps', 'offices', 'selectedCorpId', 'selectedYear', 'selectedMonth', 'users'));
    }


    public function filter(Request $request)
    {
        // Fetch users based on the selected corp and office
        $corpId = $request->input('corps_id');
        $officeId = $request->input('office_id');
        $userId = $request->input('user_id');
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('n'));



        // Retrieve corp name based on corp ID
$corp = Corp::find($corpId);
$corpName = $corp ? $corp->corp_name : null;








        $users = User::query();

        if ($corpId && $officeId && $userId !== 'all') {
            $users->whereHas('office', function ($query) use ($corpId, $officeId) {
                $query->where('corp_id', $corpId)
                    ->where('id', $officeId);
            })->where('id', $userId);
        } elseif ($corpId && $officeId && $userId === 'all') {
            $users->whereHas('office', function ($query) use ($corpId, $officeId) {
                $query->where('corp_id', $corpId)
                    ->where('id', $officeId);
            });
        } elseif ($corpId && $userId !== 'all') {
            $users->whereHas('office', function ($query) use ($corpId) {
                $query->where('corp_id', $corpId);
            })->where('id', $userId);
        } elseif ($corpId && $userId === 'all') {
            $users->whereHas('office', function ($query) use ($corpId) {
                $query->where('corp_id', $corpId);
            });
        } elseif ($officeId && $userId !== 'all') {
            $users->where('office_id', $officeId)->where('id', $userId);
        } elseif ($officeId && $userId === 'all') {
            $users->where('office_id', $officeId);
        } elseif ($userId === 'all') {
            $users = User::with('office');
        } elseif ($userId !== 'all') {
            $users->where('id', $userId);
        }

        // $holidays = VacationCalendar::getHolidaysForRange(
        //     $startDate->format('Y-m-d'),
        //     $endDate->format('Y-m-d'),
        //     $officeId
        // );

        // If neither corpId, officeId, nor userId is provided, fetch all users
        if (!$corpId && !$officeId && !$userId) {
            $users = User::with('office');
        }


        $startDate=Carbon::create($selectedYear, $selectedMonth, 16)->subMonth();
        $endDate=Carbon::create($selectedYear,$selectedMonth,15);




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


        // Calculate breaks for each user in the result set
        $breakData = [];
        foreach ($users as $user) {
            $breakData[$user->id] = calculateTotalBreakMinutes($user->id, $startDate, $endDate);
        }
        // dd($breakData);

        $holidays=VacationCalendar::getHolidaysForRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $officeId);



        // dd($holidays->first());
// dd(

//     [
//         'dasfasdf'=>$holidays
//     ]);

        return view('user', compact('users', 'selectedYear', 'selectedMonth','startDate','endDate', 'holidays','corpName','breakData'));
    }

}

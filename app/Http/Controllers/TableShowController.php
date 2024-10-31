<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Breaks;
use Illuminate\Http\Request;
use App\Models\VacationCalendar;
use App\Models\AttendanceTypeRecord;
use Illuminate\Support\Facades\Auth;

class TableShowController extends Controller
{
    public function index()
    {

    // $isOnBreak = $this->getBreakStatus($request)->original['isOnBreak'];

        $year = date(format: 'Y');
        $user = auth()->user();

        $month = date('m');
        $officeId = $user->office_id; //

        $today = Carbon::today();
        $dayOfMonth = $today->day;

        $givenDate = Carbon::parse($year . '-' . $month . '-16');

        // Default logic for 1st to 15th
        $previousMonthStart = $givenDate->copy()->subMonth(); // Previous month starting 16th
        $currentMonthStart = $givenDate->copy(); // Current month starting 16th

        if ($today->day >= 16) {
            // If today is the 16th or later, shift the logic
            $previousMonthStart = $givenDate->copy(); // Previous month becomes this month
            $currentMonthStart = $givenDate->copy()->addMonth(); // Current month becomes next month
        }

        $daysInPreviousMonth = $previousMonthStart->daysInMonth;

        $startDate = $previousMonthStart->copy()->startOfDay();
        $endDate = $currentMonthStart->copy()->subDay()->endOfDay();

        // $holidays = VacationCalendar::getHolidaysForRange(
        // $startDate->format('Y-m-d'),
        // $endDate->format('Y-m-d'),
        // $officeId
        $holidays = VacationCalendar::getHolidaysForRange(
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
            $officeId
        );

        // dd($holidays);



    // dd($holidays);
    $attendanceTypeRecords = AttendanceTypeRecord::all();
     // Fetch bosses who belong to the same office as the authenticated user
     $bosses = User::where('is_boss', true)
     ->where('office_id', $officeId)  // Only fetch bosses from the same office
     ->get();

    // dd($attendanceTypeRecords);
    //bREAK MODEL -OOR HOLBOSONOO END DUUDAJ AJILUULAH
    // Fetch break times for the user within the date range
        // $breaks=Breaks::where('user_id', $user->id)//end ehleed $breaks gej variable zarlaad ter ni Break modeliing user id gaar olj bna
        //                 ->whereBetween('start_time', [$startDate,$endDate])
        //                 ->get() //get function
        //                 ->groupBy(function ($break){
        //                     return Carbon::parse($break->start_time)->format('Y-m-d');
        //                 })
        //                 ->map(function ($dayBreaks){
        //                     return $dayBreaks->sum(function ($break){
        //                         $start=Carbon::parse($break->start_time);
        //                         $end=Carbon::parse($break->end_time);
        //                         return $end->diffInMinutes($start);
        //                     });
        //                 });
        $totalMinutes=0;
        $breaks = Breaks::where('user_id', $user->id)
        ->whereBetween('start_time', [$startDate, $endDate])
        ->get()
        ->groupBy(function ($break) {
            // Group by date (Y-m-d format) to calculate the total minutes per day
            return Carbon::parse($break->start_time)->format('Y-m-d');
        })
        ->map(function ($dayBreaks) {
            // Sum the total minutes for each break across the three intervals
            return $dayBreaks->sum(function ($break) {
                $totalMinutes = 0;

                // Define the skip range for the day of the first break
                $firstBreakDate = Carbon::parse($break->start_time);
                $skipStart = Carbon::createFromFormat('Y-m-d H:i', $firstBreakDate->format('Y-m-d') . ' 12:00');
                $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $firstBreakDate->format('Y-m-d') . ' 13:00');

                // Calculate duration for the first break
                $firstStart = Carbon::parse($break->start_time);
                $firstEnd = Carbon::parse($break->end_time);
                $totalMinutes += $this->calculateValidMinutes($firstStart, $firstEnd, $skipStart, $skipEnd);

                // Calculate duration for the second break
                if (isset($break->start_time2) && isset($break->end_time2)) {
                    $secondStart = Carbon::parse($break->start_time2);
                    $secondEnd = Carbon::parse($break->end_time2);

                    // Update skip range for the second break
                    $skipStart = Carbon::createFromFormat('Y-m-d H:i', $secondStart->format('Y-m-d') . ' 12:00');
                    $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $secondStart->format('Y-m-d') . ' 13:00');

                    $totalMinutes += $this->calculateValidMinutes($secondStart, $secondEnd, $skipStart, $skipEnd);
                }

                // Calculate duration for the third break
                if (isset($break->start_time3) && isset($break->end_time3)) {
                    $thirdStart = Carbon::parse($break->start_time3);
                    $thirdEnd = Carbon::parse($break->end_time3);

                    // Update skip range for the third break
                    $skipStart = Carbon::createFromFormat('Y-m-d H:i', $thirdStart->format('Y-m-d') . ' 12:00');
                    $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $thirdStart->format('Y-m-d') . ' 13:00');

                    $totalMinutes += $this->calculateValidMinutes($thirdStart, $thirdEnd, $skipStart, $skipEnd);
                }

                return $totalMinutes;

            });
        });

    // Send the $breaks array (which contains total minutes for each day) to the view
    $tbody = view('includes.time-table-body', [
        'user' => $user,
        'month' => $month,
        'year' => $year,
        'holidays' => $holidays,
        'daysInPreviousMonth' => $daysInPreviousMonth,
        'totalMinutes' => $totalMinutes, // This contains the total minutes for each day
        'startDate' => $startDate,
        'endDate' => $endDate,
        'attendanceTypeRecords' => $attendanceTypeRecords,
        'bosses' => $bosses,
        'breaks' => $breaks,
    ])->render();
    // return ["break"=>$breaks, "start" => $startDate, "end" => $endDate];
// dd($holidays);

    return view('dashboard', compact('tbody'));


    }

    // public function omnoh($year, $month)
    // {
    //     $year = (int)$year;
    //     $month = (int)$month;
    //     if (!$month || !$year) {
    //         return abort(404);
    //     }

    //     $user = auth()->user();
    //     $officeId = $user->office_id;


    //     $previousMonthStart = Carbon::parse($year . '-' . $month . '-16');
    //     $currentMonthStart = Carbon::parse($year . '-' . $month . '-16');
    //     $daysInPreviousMonth = $previousMonthStart->daysInMonth;

    //     $startDate = $previousMonthStart->copy()->startOfDay();
    //     $endDate = $currentMonthStart->copy()->endOfDay()->addMonth();

    //     $holidays = VacationCalendar::getHolidaysForRange(
    //         $startDate->format('Y-m-d'),
    //         $endDate->format('Y-m-d'),
    //         $officeId
    //     );

    //     $tbody = view('includes.time-table-body', [
    //         'user' => $user,
    //         'month' => $month,
    //         'year' => $year,
    //         'holidays' => $holidays,
    //         'daysInPreviousMonth' => $daysInPreviousMonth,
    //     ])->render();

    //     return view('dashboard', compact('tbody'));
    // }

    // Function to calculate total minutes between two DateTime objects
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

    public function showPreviousMonth(Request $request)
    {
        $user = auth()->user();
        $officeId = $user->office_id; // Assuming the user model has an 'office_id' property


        $currentMonth = $request->session()->get('current_month', Carbon::now()->month);
        $currentYear = $request->session()->get('current_year', Carbon::now()->year);

        if ($currentMonth == 1) {
            $month = 12;
            $year = $currentYear - 1;
        } else {
            $month = $currentMonth - 1;
            $year = $currentYear;
        }

        $request->session()->put('current_month', $month);
        $request->session()->put('current_year', $year);

        $previousMonthStart = Carbon::parse($year . '-' . $month . '-16');
        $currentMonthStart = Carbon::parse($year . '-' . $month . '-16');
        $daysInPreviousMonth = $previousMonthStart->daysInMonth;

        $startDate = $previousMonthStart->copy()->startOfDay();
        $endDate = $currentMonthStart->copy()->endOfDay()->addMonth();

        $holidays = VacationCalendar::getHolidaysForRange(
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
            $officeId
        );
        $attendanceTypeRecords = AttendanceTypeRecord::all();

        $bosses = User::where('is_boss', true)
        ->where('office_id', $officeId)  // Only fetch bosses from the same office
        ->get();

        $breaks = Breaks::where('user_id', $user->id)
        ->whereBetween('start_time', [$startDate, $endDate])
        ->get()
        ->groupBy(function ($break) {
            // Group by date (Y-m-d format) to calculate the total minutes per day
            return Carbon::parse($break->start_time)->format('Y-m-d');
        })
        ->map(function ($dayBreaks) {
            // Sum the total minutes for each break across the three intervals
            return $dayBreaks->sum(function ($break) {
                $totalMinutes = 0;

                // First interval
                if ($break->start_time && $break->end_time) {
                    $start = Carbon::parse($break->start_time);
                    $end = Carbon::parse($break->end_time);
                    $totalMinutes += $end->diffInMinutes($start);
                }

                // Second interval
                if ($break->start_time2 && $break->end_time2) {
                    $start2 = Carbon::parse($break->start_time2);
                    $end2 = Carbon::parse($break->end_time2);
                    $totalMinutes += $end2->diffInMinutes($start2);
                }

                // Third interval
                if ($break->start_time3 && $break->end_time3) {
                    $start3 = Carbon::parse($break->start_time3);
                    $end3 = Carbon::parse($break->end_time3);
                    $totalMinutes += $end3->diffInMinutes($start3);
                }
// dd($totalMinutes);
                return $totalMinutes; // Total break time in minutes for this day
            });
        });


        $tbody = view('includes.time-table-body', [
            'user' => $user,
            'month' => $month,
            'year' => $year,
            'holidays' => $holidays,
            'daysInPreviousMonth' => $daysInPreviousMonth,
            // 'totalMinutes' => $totalMinutes, // This contains the total minutes for each day
            'startDate' => $startDate,
            'endDate' => $endDate,
            'attendanceTypeRecords' => $attendanceTypeRecords,
            'bosses' => $bosses,
            'breaks' => $breaks,
            //  'breaks' => $breaks,

        ])->render();

        return view('dashboard', compact('tbody'));
    }

    public function showNextMonth(Request $request)
    {
        $user = auth()->user();
        $officeId = $user->office_id; // Assuming the user model has an 'office_id' property
        $attendanceTypeRecords = AttendanceTypeRecord::all();

        $currentMonth = $request->session()->get('current_month', Carbon::now()->month);
        $currentYear = $request->session()->get('current_year', Carbon::now()->year);

        if ($currentMonth == 12) {
            $month = 1;
            $year = $currentYear + 1;
        } else {
            $month = $currentMonth + 1;
            $year = $currentYear;
        }

        $request->session()->put('current_month', $month);
        $request->session()->put('current_year', $year);

        $previousMonthStart = Carbon::parse($year . '-' . $month . '-16');
        $currentMonthStart = Carbon::parse($year . '-' . $month . '-16');
        $daysInPreviousMonth = $previousMonthStart->daysInMonth;

        $startDate = $previousMonthStart->copy()->startOfDay();
        $endDate = $currentMonthStart->copy()->endOfDay()->addMonth();

        $holidays = VacationCalendar::getHolidaysForRange(
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
            $officeId
        );
        $attendanceTypeRecords = AttendanceTypeRecord::all();

        $bosses = User::where('is_boss', true)
        ->where('office_id', $officeId)  // Only fetch bosses from the same office
        ->get();


        $breaks = Breaks::where('user_id', $user->id)
        ->whereBetween('start_time', [$startDate, $endDate])
        ->get()
        ->groupBy(function ($break) {
            // Group by date (Y-m-d format) to calculate the total minutes per day
            return Carbon::parse($break->start_time)->format('Y-m-d');
        })
        ->map(function ($dayBreaks) {
            // Sum the total minutes for each break across the three intervals
            return $dayBreaks->sum(function ($break) {
                $totalMinutes = 0;

                // First interval
                if ($break->start_time && $break->end_time) {
                    $start = Carbon::parse($break->start_time);
                    $end = Carbon::parse($break->end_time);
                    $totalMinutes += $end->diffInMinutes($start);
                }

                // Second interval
                if ($break->start_time2 && $break->end_time2) {
                    $start2 = Carbon::parse($break->start_time2);
                    $end2 = Carbon::parse($break->end_time2);
                    $totalMinutes += $end2->diffInMinutes($start2);
                }

                // Third interval
                if ($break->start_time3 && $break->end_time3) {
                    $start3 = Carbon::parse($break->start_time3);
                    $end3 = Carbon::parse($break->end_time3);
                    $totalMinutes += $end3->diffInMinutes($start3);
                }
// dd($totalMinutes);
                return $totalMinutes; // Total break time in minutes for this day
            });
        });


        $tbody = view('includes.time-table-body', [
            'user' => $user,
            'month' => $month,
            'year' => $year,
            'holidays' => $holidays,
            'daysInPreviousMonth' => $daysInPreviousMonth,
            // 'totalMinutes' => $totalMinutes, // This contains the total minutes for each day
            'startDate' => $startDate,
            'endDate' => $endDate,
            'attendanceTypeRecords' => $attendanceTypeRecords,
            'bosses' => $bosses,
            'breaks' => $breaks,
        ])->render();

        return view('dashboard', compact('tbody'));
    }

    public function showNotifications()
    {
        $notifications = auth()->user()->notifications;

        return view('notifications', compact('notifications'));
    }
    //home deerh post hewlehiig end duudah

    public function home()
    {

        $userCorpId=Auth::user()->corp_id;

        $posts = Post::where(function($query) use ($userCorpId) {
            $query->doesntHave('corps') // Posts visible to all
                  ->orWhereHas('corps', function($q) use ($userCorpId) {
                      $q->where('corps.id', $userCorpId);
                  });
        })
        ->latest()
        ->paginate(10);

        return view('home', compact('posts'));
    }



}

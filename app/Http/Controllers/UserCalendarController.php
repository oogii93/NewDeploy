<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\VacationCalendar;
use Illuminate\Http\Request;

class UserCalendarController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user's corporation ID
        $userCorpId = auth()->user()->corp_id;
        $selectedYear = $request->input('year', date('Y'));

        // Get the corporation details
        $selectedCorp = auth()->user()->corp;
        $calendar = $this->generateCalendar($userCorpId, $selectedYear);

        return view('user.calendar', compact('calendar', 'selectedYear', 'selectedCorp'));
    }

    private function generateCalendar($corpId, $year)
    {
        // Fetch holidays for the user's corp and selected year
        $holidays = VacationCalendar::where('corp_id', $corpId)
            ->whereYear('vacation_date', $year)
            ->get()
            ->pluck('vacation_date')
            ->toArray();

        // Generate the calendar data structure
        $calendar = [];
        for ($month = 1; $month <= 12; $month++) {
            $calendar[$month] = $this->generateMonthCalendar($year, $month, $corpId, $holidays);
        }

        return $calendar;
    }

    private function generateMonthCalendar($year, $month, $corpId, $holidays)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthCalendar = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $dayOfWeek = $date->dayOfWeek;

            // Fetch the holiday for the current date and corporation
            $holiday = VacationCalendar::whereDate('vacation_date', $date->format('Y-m-d'))
                ->where('corp_id', $corpId)
                ->first();

            $monthCalendar[$day] = [
                'date' => $date,
                'dayOfWeek' => $dayOfWeek,
                'isHoliday' => $holiday ? true : false,
            ];
        }

        return $monthCalendar;
    }
}

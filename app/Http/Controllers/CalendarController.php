<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Corp;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\VacationCalendar;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $corps = Corp::get();
        $offices = Office::all();
        $selectedCorpId = $request->input('corps_id');




        return view('admin.calendar.index', compact('corps', 'offices', 'selectedCorpId'));
    }

    public function store(Request $request)
    {

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $weekdays = $request->input('weekdays', []);
        $corpId=$request->input('corps_id');

       if($corpId){
        $this->processVacationAndHolidays($corpId, $fromDate, $toDate, $weekdays);
       }else{
        $corps=Corp::all();

        foreach ($corps as $corp)
        {
            $this->processVacationAndHolidays($corp->id, $fromDate, $toDate, $weekdays);
        }
       }

        return redirect()->back()->with('success', '休日が保存されました。');

        // Redirect or return a response as needed
    }

    protected function processVacationAndHolidays($corpId, $fromDate, $toDate, $weekdays)
    {
        $corp = Corp::findOrFail($corpId);
    $offices = Office::where('corp_id', $corpId)->get();

        // Create a date range between the from and to dates
        $dates = $this->createDateRange($fromDate, $toDate);


        foreach ($offices as $office) {
        foreach ($dates as $date) {
            // Check if the current date is a weekday or a holiday
            $isWeekday = $this->isWeekday($date, $weekdays);

            if ($isWeekday) {
                // Store the vacation or holiday data for the current date
                $office->vacationCalendars()->create([
                    'vacation_date' => $date,
                    'corp_id' => $corpId,
                    'office_id' =>$office->id,
                ]);
            }
        }
    }
}


    protected function createDateRange($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return $this->dateRange($start, $end);
    }

 protected function dateRange($start, $end)
 {
    $dates=[];

    $current=$start->copy();

    while($current <= $end){
        $dates[]=$current->format('Y-m-d');
        $current->addDay();
    }
    return $dates;
 }

    protected function isWeekday($date, $weekdays)
{
    $dayOfWeek = strtolower(date('l', strtotime($date)));

    // Check if the day of the week matches the selected weekdays
    return in_array($dayOfWeek, $weekdays)|| in_array('holiday', $weekdays);
}


public function addHoliday(Request $request)
{
    $date = $request->input('date');
    $corpId = $request->input('corp_id');

    if (!$corpId) {
        // Handle the case where corp_id is missing or null
        return redirect()->back()->withErrors(['error' => 'Corp ID is required']);
    }

    // Get all the offices for the selected corp_id
    $offices = Office::where('corp_id', $corpId)->get();

    // Loop through each office and create a new holiday entry
    foreach ($offices as $office) {
        VacationCalendar::create([
            'vacation_date' => Carbon::parse($date),
            'corp_id' => $corpId,
            'office_id' => $office->id,
        ]);
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', '休日が正常に追加されました');
}

public function editHoliday(Request $request, $holidayId)
{
    $holiday = VacationCalendar::findOrFail($holidayId);
    // Update the holiday entry with the new date or other data
    $holiday->update($request->all());
    return response()->json(['success' => true]);
}

public function deleteHoliday(Request $request, $holidayId, $officeId,$corpId)
{
    $holiday = VacationCalendar::where('id', $holidayId)
        ->where('corp_id', $corpId)
        ->where('office_id', $officeId)
        ->first();

    if ($holiday) {
        $holiday->delete();
        // dd($holidayId, $officeId,$corpId,$holiday);
        // Redirect back with a success message
        return redirect()->back()->with('success', '休日が正常に削除されました');
    } else {
        // Redirect back with an error message
        return redirect()->back()->with('error', '休日が見つかりません');
    }
}

public function getHolidayData($holidayId)
{
    $holiday = VacationCalendar::findOrFail($holidayId);
    return response()->json($holiday);
}


}

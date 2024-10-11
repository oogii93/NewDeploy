<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Breaks extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'start_time',
        'end_time',
        'start_time2',
        'end_time2',
        'start_time3',
        'end_time3',
    ];

    protected $dates = [
        'start_time',
        'end_time',
        'start_time2',
        'end_time2',
        'start_time3',
        'end_time3',
    ];


       // Helper method to calculate time difference in minutes
       public function getTimeDifferenceInMinutes($start, $end)
       {
           if (!$start || !$end) {
               return 0;
           }
           return Carbon::parse($end)->diffInMinutes(Carbon::parse($start));
       }

       // Method to get total break time in minutes
       public function getTotalBreakTimeInMinutesWithSkip()
       {
           $totalMinutes = 0;

           // Define the skip range for the day of the break
           $breakDate = Carbon::parse($this->start_time);
           $skipStart = Carbon::createFromFormat('Y-m-d H:i', $breakDate->format('Y-m-d') . ' 12:00');
           $skipEnd = Carbon::createFromFormat('Y-m-d H:i', $breakDate->format('Y-m-d') . ' 13:00');

           // Calculate duration for the first break
           if ($this->start_time && $this->end_time) {
               $start = Carbon::parse($this->start_time);
               $end = Carbon::parse($this->end_time);
               $totalMinutes += $this->calculateValidMinutes($start, $end, $skipStart, $skipEnd);
           }

           // Calculate duration for the second break
           if ($this->start_time2 && $this->end_time2) {
               $start = Carbon::parse($this->start_time2);
               $end = Carbon::parse($this->end_time2);
               $totalMinutes += $this->calculateValidMinutes($start, $end, $skipStart, $skipEnd);
           }

           // Calculate duration for the third break
           if ($this->start_time3 && $this->end_time3) {
               $start = Carbon::parse($this->start_time3);
               $end = Carbon::parse($this->end_time3);
               $totalMinutes += $this->calculateValidMinutes($start, $end, $skipStart, $skipEnd);
           }

           return $totalMinutes;
       }

       private function calculateValidMinutes($start, $end, $skipStart, $skipEnd)
       {
           $totalMinutes = 0;

           if ($start->lt($skipStart)) {
               if ($end->lte($skipStart)) {
                   $totalMinutes = $start->diffInMinutes($end);
               } elseif ($end->lte($skipEnd)) {
                   $totalMinutes = $start->diffInMinutes($skipStart);
               } else {
                   $totalMinutes = $start->diffInMinutes($skipStart) + $skipEnd->diffInMinutes($end);
               }
           } elseif ($start->lt($skipEnd)) {
               if ($end->lte($skipEnd)) {
                   $totalMinutes = 0;
               } else {
                   $totalMinutes = $skipEnd->diffInMinutes($end);
               }
           } else {
               $totalMinutes = $start->diffInMinutes($end);
           }

           return $totalMinutes;
       }


    public function user()
    {
        return $this->belongsTo(User::class);
     }

}

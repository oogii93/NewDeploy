<?php

namespace App\Models;

use App\Models\AttendanceTypeRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeOffRequestRecord extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'boss_id',
        'attendance_type_records_id',
        'date',
        'reason',
        'reason_select',
        'status',
        'is_checked',
        'checked_by',
        'checked_at',
        'division_id',
        'date2',
        'is_first_approval',

        'hr_checked',
        'hr_checked_by',
        'hr_checked_at',

    ];

    public function scopeUncheckedHrNotifications(Builder $query)
    {
        $result = $query->where('status', 'approved')
                       ->whereIn('division_id', [6, 9])
                       ->where('hr_checked', false);

        // \Log::info('Unchecked HR Notifications Query', [
        //     'sql' => $result->toSql(),
        //     'bindings' => $result->getBindings(),
        //     'count' => $result->count()
        // ]);

        return $result;
    }

    protected $casts = [
        'checked_at' => 'datetime',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }


    public function attendanceTypeRecord() {
        return $this->belongsTo(AttendanceTypeRecord::class, 'attendance_type_records_id');
    }

    public function boss()
{
    return $this->belongsTo(User::class, 'boss_id');
}
}

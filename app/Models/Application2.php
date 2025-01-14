<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\NewApplication2Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Builder;


class Application2 extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'is_checked',
        'checked_by',
        'checked_at',
        'comment',

        'hr_checked',
        'hr_checked_by',
        'hr_checked_at',
    ];


    public function scopeUncheckedNonComputerNotifications(Builder $query)
    {
        return $query->where('status','pending')
        // ->whereIn('division_id', [6, 9])
        ->where('hr_checked', false)
        ->where('applicationable2_type', '!=', 'App\Models\ComputerFormType01Z');
    }
    public function scopeUncheckedHrNotifications(Builder $query)
    {
        return $query->where('status','pending')
        // ->whereIn('division_id', [6, 9])
        ->where('hr_checked', false)
        ->where('applicationable2_type', 'App\Models\ComputerFormType01Z');
    }

    public function pastExample()
{
    return $this->hasMany(PastExample::class);

}

    protected $table = 'applications2'; // Explicitly specify the table name




    protected static function booted()
    {
        static::created(function ($application) {
            // Get users from 太成HD corporation and 本社 office
            $usersToNotify = User::whereHas('corp', function($query) {
                $query->where('corp_name', '太成HD');
            })
            ->whereHas('office', function($query) {
                $query->where('office_name', '本社');
            })
            ->get();

            // Send notification to each user
            foreach ($usersToNotify as $user) {
                $user->notify(new NewApplication2Notification($application));
            }
        });
    }


    protected $casts = [
        'is_checked' => 'boolean',
        'checked_at' => 'datetime',
        'is_first_approval' => 'boolean', // Add this line

    ];

    public function applicationable2()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}


<?php

namespace App\Models;

use App\Models\Corp;
use DateTimeInterface;
use App\Models\UserDetail;
use App\Models\UserBankDetails;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; // Add this line

class User extends Authenticatable
{
    use Notifiable,HasApiTokens, HasFactory,HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     public $table = 'users';

     protected $fillable=[
        'name',
        'email',
        'password',
        'remember_token',
        'is_boss',
        'office_id',
        'employer_id',
        'division_id',
        'corp_id',
        'furigana',
        'gender',
        'birthdate',
        'post_number',
        'address'
     ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     *
     *
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define the relationship with ArrivalRecord model
     */
    // public function arrivalRecords()
    // {
    //     return $this->hasMany(ArrivalRecord::class);
    // }


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function userArrivalRecords()
    {
        return $this->hasMany(ArrivalRecord::class, 'user_id', 'id');
    }

    public function office()
{
    return $this->belongsTo(Office::class);
}
    public function corp()
{
    return $this->belongsTo(Corp::class);
}


// new
public function timeOffRequestRecords() {
    return $this->hasMany(TimeOffRequestRecord::class);
}

public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
public function applications2()
    {
        return $this->hasMany(Application2::class, 'user_id');
    }


public function bossApplications()
{
    return $this->hasMany(Application::class, 'boss_id');
}

public function division()
{
    return $this->belongsTo(Division::class);
}

// public function dailyRecord()
// {
//     return $this->hasMany(DailyRecord::class, 'user_id', 'id');
// }

public function appointments()
{
    return $this->hasMany(Appointment::class);
}


public function userDetail()
{
    return $this->hasOne(UserDetail::class);
}
public function userBankDetail()
{
    return $this->hasOne(UserBankDetails::class);
}
public function userFamily()
{
    return $this->hasMany(UserFamily::class);
}










}

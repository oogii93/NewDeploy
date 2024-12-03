<?php

namespace App\Models;

use App\Models\VacationCalendar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corp extends Model
{
    use HasFactory,SoftDeletes;
  protected $fillable=[
    'corp_name'

  ];

    public function offices()
{
    return $this->hasMany(Office::class, 'corp_id');
}

public function vacationCalendars()
{
    return $this->hasMany(VacationCalendar::class);
}

public function rooms()
{
    return $this->hasMany(Room::class);
}

public function calculations()
{
    return $this->hasMany(Calculation::class, 'corps_id');
}

public function divisions()
{
    return $this->hasMany(Division::class, 'corp_id');
}

public function users()
{
    return $this->hasMany(User::class);
}

public function cars()
{
    return $this->hasMany(Car::class, 'corp_id', 'id');
}


}

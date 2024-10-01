<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable=['room_id', 'title', 'description', 'start_time', 'end_time', 'user_id','color'];
    protected $casts=[
        'start_time'=>'datetime',
        'end_time'=>'datetime',
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

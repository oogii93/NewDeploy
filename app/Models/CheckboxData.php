<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckboxData extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'date',
        'is_checked',
        'arrival_recorded_at',
        'departure_recorded_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

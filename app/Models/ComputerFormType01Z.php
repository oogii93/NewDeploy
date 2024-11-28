<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerFormType01Z extends Model
{
    use HasFactory;

    protected $fillable = [
        'corp', 'office', 'name', 'occured_date',
        'description', 'answer', 'screen_copy', 'self_attempt'
    ];

    protected $table = 'computer_form_type_01_z'; // Ensure this matches your actual table name

    public function applicationable2()
    {
        return $this->morphOne(Application2::class, 'applicationable2');
    }
}

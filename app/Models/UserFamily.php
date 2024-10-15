<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFamily extends Model
{

    use HasFactory;


    protected $table = 'user_family';
    protected $fillable=[
        'user_id',
        'family_name',
        'family_relationship',
        'family_birthdate',
        'family_dependent_status',
        'family_cohabiting_parent',
        'family_disability_status',
        'family_address_type',
        'family_address',
        'family_estimated_income',
        'family_insurance_status',
        'family_name_furigana'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

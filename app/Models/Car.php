<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'car_id',
        'number_plate',
        'car_type',
        'car_made_year',
        'car_insurance_company',
        'car_insurance_start',
        'car_insurance_end',
        'etc',
        'image_path',
        'car_detail',
        'corp_id'
    ];
    protected $table = 'car'; // Correct table name

    public function corp()
{
    return $this->belongsTo(Corp::class,'corp_id', 'id');
}
}

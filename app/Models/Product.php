<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable=[
        'office_name',
        'maker_name',
        'product_number',
        'product_name',
        'pieces',
        'icm_net',
        'purchase_date',
        'purchased_from',
        'list_price',
        'remarks'
    ];
}

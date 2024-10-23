<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NameCard extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'company', 'phone', 'email', 'image','ocr_text'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NameCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'mobile',
        'fax',
        'company',
        'address',
        'image_path'
    ];

        // Optional: Mutator to get full image URL
        public function getImageUrlAttribute()
        {
            return $this->image_path
                ? asset('storage/namecards/' . $this->image_path)
                : null;
        }
}

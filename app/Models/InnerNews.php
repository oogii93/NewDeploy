<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InnerNews extends Model
{
    use HasFactory;

protected $fillable = ['title', 'content','categories_data'];

        protected $casts=[
            'categories_data'=>'array'
        ];


        public function getCategoriesDataAttribute($value){
            if(is_string($value)){
                return json_decode($value, true) ?? [];
            }
            return $value ?? [];
        }

}

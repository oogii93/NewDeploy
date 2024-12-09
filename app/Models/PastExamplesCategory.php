<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastExamplesCategory extends Model
{
    use HasFactory;

    protected $table ='past_examples_category';


    protected $fillable=[
        'name'
    ];

    public function pastexample()
    {
        return $this->hasMany(PastExample::class);
    }
}

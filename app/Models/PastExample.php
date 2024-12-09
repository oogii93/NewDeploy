<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastExample extends Model
{
    use HasFactory;



    protected $fillable=[
        'title',
        'description',
        'past_examples_category_id'

    ];

    public function application2()
{
    return $this->belongsTo(Application2::class);
}

    public function category()
    {
        return $this->belongsTo(PastExamplesCategory::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use SebastianBergmann\Template\Template;

class NewsCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'fields'];
    protected $casts=[
        'fields'=>'array',
    ];


    public function entries()
    {
        return $this->hasMany(CategoryEntry::class);
    }

    public function template()
    {
        return $this->hasMany(Template::class);
    }
}

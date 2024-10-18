<?php

namespace App\Models;

use App\Models\Application2;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application2Type01A extends Model
{

    use HasFactory;
    protected $guarded=[];

    protected $table = 'application2_type_01_a'; // Correct table name
    public function applicationable2()
    {
        return $this->morphOne(Application2::class, 'applicationable2');
    }
}

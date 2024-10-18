<?php

namespace App\Models;

use App\Models\Application2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application2Type03A extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $table = 'application2_type_03_a'; // Correct table name
    public function applicationable2()
    {
        return $this->morphOne(Application2::class, 'applicationable2');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationType5A extends Model
{
    use HasFactory;
    protected $table = 'application_type_5_a'; // Correct table name
    protected $guarded=[];

    public function application()
    {
        return $this->morphOne(Application::class, 'applicationable');
    }
}

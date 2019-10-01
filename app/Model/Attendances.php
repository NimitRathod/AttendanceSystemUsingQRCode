<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'students_masters_id', 'lectures_id','date',
    ];
}

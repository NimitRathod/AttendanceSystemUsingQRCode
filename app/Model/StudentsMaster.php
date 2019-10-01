<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentsMaster extends Model
{
    protected $table = 'students_masters';

    protected $fillable = [
        'user_id', 'batch', 'division',
    ];

    public function Users()
    {
        // return $this->hasOne('App\User');
        // return $this->hasOne('App\User','user_id');
        return $this->belongsTo('App\User','user_id');
    }
}

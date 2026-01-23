<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // app/Models/Attendance.php
    protected $fillable = [
        'user_id',
        'date',
        'time',
        'latitude',
        'longitude',
    ];
}

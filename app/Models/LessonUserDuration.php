<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonUserDuration extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'seconds',
    ];
}


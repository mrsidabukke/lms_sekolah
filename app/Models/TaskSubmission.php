<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'submission_link',
        'submitted_at',
        'status',
        'teacher_note',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $table = 'task_submissions';

    protected $fillable = [
        'student_id',
        'task_id',
        'submission_link',
        'note',
        'score',
        'feedback',
        'status',
        'submitted_at',
        'graded_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'score' => 'integer',
    ];

    // Relationship dengan Student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship dengan Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Scope untuk submission yang sudah dikumpulkan
    public function scopeSubmitted($query)
    {
        return $query->where('status', '!=', 'draft');
    }

    // Scope untuk submission yang sudah dinilai
    public function scopeGraded($query)
    {
        return $query->whereNotNull('graded_at');
    }

    // Helper: Check if submission is late
    public function getIsLateAttribute()
    {
        if (!$this->submitted_at || !$this->task->deadline) {
            return false;
        }

        return $this->submitted_at->greaterThan($this->task->deadline);
    }

    // Helper: Get grade letter
    public function getGradeLetterAttribute()
    {
        if (!$this->score || !$this->task->max_score) {
            return null;
        }

        $percentage = ($this->score / $this->task->max_score) * 100;

        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }
}

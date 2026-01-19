<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $table = 'quiz_attempts';

    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
        'is_passed',
        'answers',
        'started_at',
        'submitted_at',
        'time_spent_seconds'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'score' => 'integer',
        'is_passed' => 'boolean',
        'time_spent_seconds' => 'integer',
        'answers' => 'array',
    ];

    // Relationship dengan Student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship dengan Quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Scope untuk attempt yang sudah submit
    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_at');
    }

    // Scope untuk attempt yang passed
    public function scopePassed($query)
    {
        return $query->where('is_passed', true);
    }

    // Helper: Format waktu pengerjaan
    public function getTimeSpentFormattedAttribute()
    {
        $minutes = floor($this->time_spent_seconds / 60);
        $seconds = $this->time_spent_seconds % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'duration_minutes',
        'passing_score',
        'max_attempts',
        'is_active',
        'available_from',
        'available_until',
        'show_correct_answers',
        'shuffle_questions'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
        'passing_score' => 'integer',
        'max_attempts' => 'integer',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'show_correct_answers' => 'boolean',
        'shuffle_questions' => 'boolean',
    ];

    // Relationship dengan Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Relationship dengan Questions
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    // Relationship dengan Attempts
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Get student's best attempt
    public function getBestAttempt($studentId)
    {
        return $this->attempts()
            ->where('student_id', $studentId)
            ->orderByDesc('score')
            ->first();
    }

    // Get student's latest attempt
    public function getLatestAttempt($studentId)
    {
        return $this->attempts()
            ->where('student_id', $studentId)
            ->latest()
            ->first();
    }

    // Check if quiz is available
    public function isAvailable()
    {
        if (!$this->is_active) return false;

        $now = now();
        if ($this->available_from && $now < $this->available_from) return false;
        if ($this->available_until && $now > $this->available_until) return false;

        return true;
    }

    // Check if student can attempt quiz
    public function canAttempt($studentId)
    {
        if (!$this->isAvailable()) return false;

        if ($this->max_attempts > 0) {
            $attemptCount = $this->attempts()
                ->where('student_id', $studentId)
                ->count();
            if ($attemptCount >= $this->max_attempts) return false;
        }

        return true;
    }
}

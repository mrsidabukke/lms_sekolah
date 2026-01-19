<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'order',
        'points',
        'explanation'
    ];

    protected $casts = [
        'order' => 'integer',
        'points' => 'integer',
    ];

    // Relationship dengan Quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Helper: Get correct answer text
    public function getCorrectAnswerAttribute()
    {
        $field = 'option_' . $this->correct_option;
        return $this->$field;
    }

    // Helper: Check if answer is correct
    public function isCorrect($answer)
    {
        return strtolower($answer) === strtolower($this->correct_option);
    }

    // Scope untuk urutan yang benar
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

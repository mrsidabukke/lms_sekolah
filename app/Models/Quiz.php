<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'module_id',
        'section_id',
        'lesson_id',
        'title',
        'position',
        'passing_score',
        'is_active',
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('score', 'is_passed')
            ->withTimestamps();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}

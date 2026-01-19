<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Progress lesson
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
            ->withPivot('is_completed')
            ->withTimestamps();
    }

    /**
     * Progress quiz
     */
    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_user')
            ->withPivot('score', 'is_passed')
            ->withTimestamps();
    }

    public function department()
{
    return $this->belongsTo(Department::class);
}


    
}

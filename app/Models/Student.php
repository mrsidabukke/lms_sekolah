<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'nisn',
        'foto',
        'jurusan',
        'class_level',
        'phone',
        'address',
        'birth_date',
        'birth_place',
        'gender',
        'religion'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'jurusan', 'code');
    }

    // Relationship dengan enrollments
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    // Relationship dengan submissions
    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    // Relationship dengan quiz attempts
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Get full profile
    public function getFullProfile()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'nisn' => $this->nisn,
            'email' => $this->user->email,
            'photo' => $this->foto ? asset('storage/' . $this->foto) : null,
            'jurusan' => $this->jurusan,
            'department' => $this->department ? $this->department->name : null,
            'class_level' => $this->class_level,
            'phone' => $this->phone,
            'address' => $this->address,
            'birth_date' => $this->birth_date?->format('Y-m-d'),
            'birth_place' => $this->birth_place,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'is_active' => $this->user->is_active,
        ];
    }
}

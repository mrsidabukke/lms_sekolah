<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'identifier',
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'nisn',
        'photo',
        'jurusan',
        'class_level',
        'is_active',
        'email_verified_at',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // Relationship dengan Student (jika role student)
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // Relationship dengan Teacher (jika role teacher)
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    // Relationship dengan Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship dengan Courses/Materials (enrollment)
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_enrollments')
                    ->withPivot('enrolled_at', 'progress', 'status')
                    ->withTimestamps();
    }

    // Relationship dengan completed materials
    public function completedMaterials()
    {
        return $this->belongsToMany(Material::class, 'material_completions')
                    ->withPivot('completed_at', 'duration_seconds')
                    ->withTimestamps();
    }

    // Scope untuk hanya siswa
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    // Scope aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Check if user is student
    public function isStudent()
    {
        return $this->role === 'student';
    }

    // Check if user is teacher
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }
}

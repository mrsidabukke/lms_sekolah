<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'head_of_department',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship dengan Users (siswa)
    public function students()
    {
        return $this->hasMany(User::class, 'department_id')->where('role', 'student');
    }

    // Relationship dengan Courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Relationship dengan Modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}

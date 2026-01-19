<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'department_id',
        'teacher_id',
        'thumbnail',
        'credit_hours',
        'duration_weeks',
        'start_date',
        'end_date',
        'is_active',
        'is_public',
        'max_students',
        'enrollment_count',
        'passing_score'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'credit_hours' => 'integer',
        'duration_weeks' => 'integer',
        'max_students' => 'integer',
        'enrollment_count' => 'integer',
        'passing_score' => 'integer',
    ];

    // Relationship dengan Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship dengan Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relationship dengan Modules
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    // Relationship dengan enrolled students
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments')
                    ->withPivot('enrolled_at', 'progress', 'status')
                    ->withTimestamps();
    }

    // Relationship dengan Materials melalui Modules
    public function materials()
    {
        return $this->hasManyThrough(Material::class, Module::class);
    }

    // Scope untuk courses aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk courses yang tersedia untuk enrollment
    public function scopeAvailableForEnrollment($query)
    {
        return $query->where('is_active', true)
                     ->where('is_public', true)
                     ->where(function($q) {
                         $q->whereNull('max_students')
                           ->orWhereRaw('enrollment_count < max_students');
                     })
                     ->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    // Get course progress for specific student
    public function getProgressForStudent($studentId)
    {
        $totalMaterials = $this->materials()->count();
        if ($totalMaterials === 0) return 0;

        $completed = MaterialCompletion::where('user_id', $studentId)
            ->whereIn('material_id', $this->materials()->pluck('id'))
            ->count();

        return round(($completed / $totalMaterials) * 100, 2);
    }

    // Check if student is enrolled
    public function isEnrolled($studentId)
    {
        return $this->students()->where('user_id', $studentId)->exists();
    }

    // Check if enrollment is open
    public function isEnrollmentOpen()
    {
        return $this->is_active
            && $this->is_public
            && now()->between($this->start_date, $this->end_date)
            && (!$this->max_students || $this->enrollment_count < $this->max_students);
    }
}

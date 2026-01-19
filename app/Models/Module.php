<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order',
        'is_active',
        'duration_minutes',
        'learning_objectives'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'duration_minutes' => 'integer',
    ];

    // Relationship dengan Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship dengan Materials
    public function materials()
    {
        return $this->hasMany(Material::class)->orderBy('order');
    }

    // Relationship dengan Quizzes
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    // Relationship dengan Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Get module progress for specific student
    public function getProgressForStudent($studentId)
    {
        $totalMaterials = $this->materials()->count();
        if ($totalMaterials === 0) return 0;

        $completed = MaterialCompletion::where('user_id', $studentId)
            ->whereIn('material_id', $this->materials()->pluck('id'))
            ->count();

        return round(($completed / $totalMaterials) * 100, 2);
    }

    // Check if all materials are completed by student
    public function isCompletedByStudent($studentId)
    {
        $totalMaterials = $this->materials()->count();
        if ($totalMaterials === 0) return false;

        $completed = MaterialCompletion::where('user_id', $studentId)
            ->whereIn('material_id', $this->materials()->pluck('id'))
            ->count();

        return $completed === $totalMaterials;
    }
}

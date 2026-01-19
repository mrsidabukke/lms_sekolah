<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    protected $table = 'course_enrollments';

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'progress',
        'status'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'progress' => 'decimal:2',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scope untuk enrollment aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'enrolled');
    }

    // Scope untuk enrollment yang selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}

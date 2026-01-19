<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'content_type',
        'content_url',
        'order',
        'duration_minutes',
        'is_active',
        'requires_completion',
        'prerequisite_material_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'duration_minutes' => 'integer',
        'requires_completion' => 'boolean',
    ];

    // Relationship dengan Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Relationship dengan Course melalui Module
    public function course()
    {
        return $this->hasOneThrough(Course::class, Module::class);
    }

    // Relationship dengan students yang menyelesaikan
    public function completions()
    {
        return $this->belongsToMany(User::class, 'material_completions')
                    ->withPivot('completed_at', 'duration_seconds', 'last_position')
                    ->withTimestamps();
    }

    // Relationship dengan prerequisite material
    public function prerequisite()
    {
        return $this->belongsTo(Material::class, 'prerequisite_material_id');
    }

    // Scope untuk materials aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Check if material is completed by student
    public function isCompletedByStudent($studentId)
    {
        return $this->completions()->where('user_id', $studentId)->exists();
    }

    // Get completion data for student
    public function getCompletionForStudent($studentId)
    {
        return $this->completions()->where('user_id', $studentId)->first();
    }

    // Check if material is accessible (prerequisite completed)
    public function isAccessibleForStudent($studentId)
    {
        if (!$this->prerequisite_material_id) return true;

        $prerequisite = Material::find($this->prerequisite_material_id);
        if (!$prerequisite) return true;

        return $prerequisite->isCompletedByStudent($studentId);
    }

    // Get next material in module
    public function nextMaterial()
    {
        return $this->module->materials()
            ->where('order', '>', $this->order)
            ->orderBy('order')
            ->first();
    }

    // Get previous material in module
    public function previousMaterial()
    {
        return $this->module->materials()
            ->where('order', '<', $this->order)
            ->orderByDesc('order')
            ->first();
    }
}

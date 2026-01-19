<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCompletion extends Model
{
    protected $table = 'material_completions';

    protected $fillable = [
        'user_id',
        'material_id',
        'duration_seconds',
        'last_position',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'duration_seconds' => 'integer',
        'last_position' => 'integer',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Scope untuk completion yang valid
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    // Helper: Format duration
    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->duration_seconds / 3600);
        $minutes = floor(($this->duration_seconds % 3600) / 60);
        $seconds = $this->duration_seconds % 60;

        if ($hours > 0) {
            return sprintf('%d jam %d menit', $hours, $minutes);
        } elseif ($minutes > 0) {
            return sprintf('%d menit %d detik', $minutes, $seconds);
        } else {
            return sprintf('%d detik', $seconds);
        }
    }
}

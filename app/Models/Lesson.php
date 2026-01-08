<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'section_id',   // ⬅️ WAJIB (sub-bab / BAB)
        'title',
        'content',
        'order',        // urutan di dalam BAB
        'position',     // ⬅️ WAJIB (urutan global lintas BAB)
    ];

    /**
     * Relasi ke user (progress belajar)
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_completed')
            ->withTimestamps();
    }

    /**
     * Relasi ke module
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Relasi ke section (BAB)
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function quiz()
{
    return $this->hasOne(Quiz::class);
}

}

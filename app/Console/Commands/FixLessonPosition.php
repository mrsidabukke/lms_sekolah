<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Section;

class FixLessonPosition extends Command
{
    protected $signature = 'lesson:fix-position {moduleId}';
    protected $description = 'Generate global position for lessons in a module';

    public function handle()
    {
        $moduleId = $this->argument('moduleId');
        $pos = 1;

        $sections = Section::where('module_id', $moduleId)
            ->orderBy('order')
            ->with(['lessons' => function ($q) {
                $q->orderBy('order');
            }])
            ->get();

        foreach ($sections as $section) {
            foreach ($section->lessons as $lesson) {
                $lesson->update(['position' => $pos]);
                $this->info("Lesson {$lesson->id} => position {$pos}");
                $pos++;
            }
        }

        $this->info('✅ Position berhasil diperbaiki');
    }
}

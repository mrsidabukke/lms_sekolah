<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Halaman belajar siswa
     */
    public function show(Lesson $lesson)
    {
        $user = Auth::user();

        /**
         * =========================
         * SECTION
         * =========================
         */
        $sections = Section::where('module_id', $lesson->module_id)
            ->orderBy('order')
            ->get();

        /**
         * =========================
         * SEMUA ITEM (LESSON + QUIZ)
         * =========================
         */
        $items = collect();

        $lessons = Lesson::where('module_id', $lesson->module_id)->get();
        $quizzes = Quiz::where('module_id', $lesson->module_id)->get();

        foreach ($lessons as $l) {
            $l->type = 'lesson';
            $items->push($l);
        }

        foreach ($quizzes as $q) {
            $q->type = 'quiz';
            $items->push($q);
        }

        // Urutkan GLOBAL
        $items = $items->sortBy('position')->values();

        /**
         * =========================
         * COMPLETED LESSON
         * =========================
         */
        $completedLessons = $user->lessons()
            ->wherePivot('is_completed', true)
            ->pluck('lessons.id')
            ->toArray();

        /**
         * =========================
         * PASSED QUIZ
         * =========================
         */
        $passedQuizzes = $user->quizzes()
            ->wherePivot('is_passed', true)
            ->pluck('quizzes.id')
            ->toArray();

        /**
         * =========================
         * LOCK SYSTEM (GLOBAL)
         * =========================
         */
        $items->each(function ($item, $index) use ($items, $completedLessons, $passedQuizzes) {

            if ($index === 0) {
                $item->is_locked = false;
            } else {
                $prev = $items[$index - 1];

                $prevCompleted =
                    ($prev->type === 'lesson' && in_array($prev->id, $completedLessons)) ||
                    ($prev->type === 'quiz' && in_array($prev->id, $passedQuizzes));

                $item->is_locked = !$prevCompleted;
            }

            if ($item->type === 'lesson') {
                $item->is_completed = in_array($item->id, $completedLessons);
            } else {
                $item->is_completed = in_array($item->id, $passedQuizzes);
            }
        });

        /**
         * =========================
         * GROUP KE SECTION
         * =========================
         */
        $sections->each(function ($section) use ($items) {
            $section->items = $items
                ->where('section_id', $section->id)
                ->values();

            // BAB tanpa item → terkunci
            $section->is_locked = $section->items->isEmpty();

            if ($section->is_locked) {
                $section->items->each(fn ($i) => $i->is_locked = true);
            }
        });

        /**
         * =========================
         * BLOK AKSES JIKA TERKUNCI
         * =========================
         */
        $current = $items
            ->where('type', 'lesson')
            ->firstWhere('id', $lesson->id);

        abort_if($current && $current->is_locked, 403);

        /**
         * =========================
         * NEXT LESSON
         * =========================
         */
        $currentIndex = $items->search(
            fn ($i) => $i->type === 'lesson' && $i->id === $lesson->id
        );

        $nextLesson = $items
            ->slice($currentIndex + 1)
            ->first(fn ($i) => $i->type === 'lesson' && !$i->is_locked);

        $isCompleted = in_array($lesson->id, $completedLessons);
        $canGoNext   = $isCompleted && $nextLesson;

        /**
         * =========================
         * PROGRESS
         * =========================
         */
        $total = $items->count();
        $done  = count($completedLessons) + count($passedQuizzes);

        $progress = $total > 0
            ? round($done / $total * 100)
            : 0;

        return view('siswa.modul.show', compact(
            'lesson',
            'sections',
            'progress',
            'nextLesson',
            'canGoNext',
            'isCompleted'
        ));
    }

    /**
     * Tandai lesson selesai
     */
    public function markAsCompleted(Lesson $lesson): RedirectResponse
    {
        $user = Auth::user();

        $user->lessons()->syncWithoutDetaching([
            $lesson->id => ['is_completed' => true]
        ]);

        return redirect()->route('siswa.modul.show', $lesson->id);
    }
}

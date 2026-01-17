<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\LessonUserDuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LessonController extends Controller
{
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
         * SEMUA LESSON
         * =========================
         */
        $lessons = Lesson::where('module_id', $lesson->module_id)
            ->orderBy('position')
            ->get();

        /**
         * =========================
         * QUIZ & TASK
         * =========================
         */
        $quizzes = Quiz::whereIn('lesson_id', $lessons->pluck('id'))->get();

        $tasks = Task::whereIn('lesson_id', $lessons->pluck('id'))
            ->where('is_active', true)
            ->get()
            ->groupBy('lesson_id');

        /**
         * =========================
         * STATUS USER
         * =========================
         */
        $completedLessons = $user->lessons()
            ->wherePivot('is_completed', true)
            ->pluck('lessons.id')
            ->toArray();

        $passedQuizzes = $user->quizzes()
            ->wherePivot('is_passed', true)
            ->pluck('quizzes.id')
            ->toArray();

        // 🔑 AMBIL SEMUA TASK SUBMISSION USER
        $completedTasks = TaskSubmission::where('user_id', $user->id)
            ->pluck('task_id')
            ->toArray();

        /**
         * =========================
         * BUILD ITEMS (LESSON → QUIZ → TASK)
         * =========================
         */
        $items = collect();

        foreach ($lessons as $l) {

            // LESSON
            $items->push((object)[
                'id'           => $l->id,
                'title'        => $l->title,
                'type'         => 'lesson',
                'section_id'   => $l->section_id,
                'position'     => $l->position * 10,
                'is_completed' => in_array($l->id, $completedLessons),
                'is_locked'    => false,
            ]);

            // QUIZ
            $quiz = $quizzes->firstWhere('lesson_id', $l->id);
            if ($quiz) {
                $items->push((object)[
                    'id'           => $quiz->id,
                    'title'        => $quiz->title,
                    'type'         => 'quiz',
                    'section_id'   => $l->section_id,
                    'position'     => ($l->position * 10) + 5,
                    'is_completed' => in_array($quiz->id, $passedQuizzes),
                    'is_locked'    => false,
                ]);
            }

            // TASK (SUB ITEM)
            if (isset($tasks[$l->id])) {
                foreach ($tasks[$l->id] as $task) {
                    $items->push((object)[
                        'id'           => $task->id,
                        'title'        => '📝 '.$task->title,
                        'type'         => 'task',
                        'section_id'   => $l->section_id,
                        'position'     => ($l->position * 10) + 8,
                        // ✅ INI FIX UTAMANYA
                        'is_completed' => in_array($task->id, $completedTasks),
                        'is_locked'    => false,
                    ]);
                }
            }
        }

        /**
         * =========================
         * SORT & LOCK SYSTEM
         * =========================
         */
        $items = $items->sortBy('position')->values();

        $items->each(function ($item, $index) use ($items) {
            if ($index === 0) {
                $item->is_locked = false;
                return;
            }
            $item->is_locked = ! $items[$index - 1]->is_completed;
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
        });

        /**
         * =========================
         * STATUS CURRENT LESSON
         * =========================
         */
        $isCompleted = in_array($lesson->id, $completedLessons);

        /**
         * =========================
         * NEXT LESSON & QUIZ
         * =========================
         */
        $currentIndex = $items->search(
            fn ($i) => $i->type === 'lesson' && $i->id === $lesson->id
        );

        $nextLesson = $items
            ->slice($currentIndex + 1)
            ->first(fn ($i) => $i->type === 'lesson' && ! $i->is_locked);

        $nextQuiz = $items
            ->slice($currentIndex + 1)
            ->first(fn ($i) =>
                $i->type === 'quiz' &&
                ! $i->is_locked &&
                ! $i->is_completed
            );

        $canGoNext = $isCompleted && $nextLesson;

        /**
         * =========================
         * PROGRESS
         * =========================
         */
        $progress = $items->count() > 0
            ? round(
                $items->where('is_completed', true)->count()
                / $items->count() * 100
            )
            : 0;

        return view('siswa.modul.show', compact(
            'lesson',
            'sections',
            'progress',
            'isCompleted',
            'nextLesson',
            'nextQuiz',
            'canGoNext'
        ));
    }

    public function markAsCompleted(Lesson $lesson): RedirectResponse
    {
        Auth::user()->lessons()->syncWithoutDetaching([
            $lesson->id => ['is_completed' => true],
        ]);

        return redirect()->route('siswa.modul.show', $lesson->id);
    }

    public function storeDuration(Request $request, Lesson $lesson)
    {
        $request->validate([
            'seconds' => 'required|integer|min:1',
        ]);

        LessonUserDuration::updateOrCreate(
            [
                'user_id'   => auth()->id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'seconds' => $request->seconds,
            ]
        );

        return response()->json(['status' => 'ok']);
    }
}

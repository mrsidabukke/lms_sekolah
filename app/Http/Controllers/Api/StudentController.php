<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\MaterialCompletion;
use App\Models\QuizAttempt;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Get student dashboard data
     */
    public function dashboard(Request $request)
    {
        $student = $request->user();

        // Total courses enrolled
        $totalCourses = $student->courses()->count();

        // Active courses (ongoing)
        $activeCourses = $student->courses()
            ->wherePivot('status', 'enrolled')
            ->whereHas('course', function($q) {
                $q->whereDate('end_date', '>=', now());
            })
            ->count();

        // Completed courses
        $completedCourses = $student->courses()
            ->wherePivot('status', 'completed')
            ->count();

        // Recent materials
        $recentMaterials = MaterialCompletion::where('user_id', $student->id)
            ->with('material.module.course')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function($completion) {
                return [
                    'material_id' => $completion->material_id,
                    'material_title' => $completion->material->title,
                    'course_title' => $completion->material->module->course->title,
                    'completed_at' => $completion->completed_at,
                ];
            });

        // Upcoming deadlines (tasks & quizzes)
        $upcomingTasks = $this->getUpcomingTasks($student->id);
        $upcomingQuizzes = $this->getUpcomingQuizzes($student->id);

        // Overall progress
        $overallProgress = $this->calculateOverallProgress($student->id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'summary' => [
                    'total_courses' => $totalCourses,
                    'active_courses' => $activeCourses,
                    'completed_courses' => $completedCourses,
                    'overall_progress' => $overallProgress,
                ],
                'recent_activities' => $recentMaterials,
                'upcoming_deadlines' => [
                    'tasks' => $upcomingTasks,
                    'quizzes' => $upcomingQuizzes,
                ],
                'current_courses' => $this->getCurrentCourses($student->id),
            ]
        ]);
    }

    /**
     * Get student progress
     */
    public function progress(Request $request)
    {
        $student = $request->user();

        $progressByCourse = $student->courses()
            ->with(['course' => function($query) use ($student) {
                $query->withCount('materials');
            }])
            ->get()
            ->map(function($enrollment) use ($student) {
                $course = $enrollment->course;
                $completedMaterials = MaterialCompletion::where('user_id', $student->id)
                    ->whereIn('material_id', $course->materials()->pluck('id'))
                    ->count();

                $progress = $course->materials_count > 0
                    ? round(($completedMaterials / $course->materials_count) * 100, 2)
                    : 0;

                return [
                    'course_id' => $course->id,
                    'course_code' => $course->code,
                    'course_title' => $course->title,
                    'total_materials' => $course->materials_count,
                    'completed_materials' => $completedMaterials,
                    'progress' => $progress,
                    'enrollment_date' => $enrollment->pivot->enrolled_at,
                    'status' => $enrollment->pivot->status,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $progressByCourse
        ]);
    }

    /**
     * Get student grades
     */
    public function grades(Request $request)
    {
        $student = $request->user();

        $grades = QuizAttempt::where('student_id', $student->id)
            ->with('quiz.module.course')
            ->get()
            ->groupBy(function($attempt) {
                return $attempt->quiz->module->course->id;
            })
            ->map(function($attempts, $courseId) {
                $course = $attempts->first()->quiz->module->course;
                $averageScore = $attempts->avg('score');
                $bestScore = $attempts->max('score');

                return [
                    'course_id' => $courseId,
                    'course_code' => $course->code,
                    'course_title' => $course->title,
                    'total_quizzes' => $attempts->unique('quiz_id')->count(),
                    'total_attempts' => $attempts->count(),
                    'average_score' => round($averageScore, 2),
                    'best_score' => round($bestScore, 2),
                    'attempts' => $attempts->map(function($attempt) {
                        return [
                            'quiz_id' => $attempt->quiz_id,
                            'quiz_title' => $attempt->quiz->title,
                            'score' => $attempt->score,
                            'is_passed' => $attempt->is_passed,
                            'attempted_at' => $attempt->attempted_at,
                        ];
                    })->values()
                ];
            })
            ->values();

        return response()->json([
            'status' => 'success',
            'data' => $grades
        ]);
    }

    /**
     * Helper: Get upcoming tasks
     */
    private function getUpcomingTasks($studentId)
    {
        // Implementation depends on your Task model
        return [];
    }

    /**
     * Helper: Get upcoming quizzes
     */
    private function getUpcomingQuizzes($studentId)
    {
        // Implementation depends on your Quiz model
        return [];
    }

    /**
     * Helper: Calculate overall progress
     */
    private function calculateOverallProgress($studentId)
    {
        $enrolledCourses = CourseEnrollment::where('user_id', $studentId)
            ->with('course')
            ->get();

        if ($enrolledCourses->isEmpty()) return 0;

        $totalProgress = 0;
        foreach ($enrolledCourses as $enrollment) {
            $totalProgress += $enrollment->course->getProgressForStudent($studentId);
        }

        return round($totalProgress / $enrolledCourses->count(), 2);
    }

    /**
     * Helper: Get current courses
     */
    private function getCurrentCourses($studentId)
    {
        return CourseEnrollment::where('user_id', $studentId)
            ->where('status', 'enrolled')
            ->with(['course' => function($query) use ($studentId) {
                $query->withCount('materials');
            }])
            ->get()
            ->map(function($enrollment) use ($studentId) {
                $course = $enrollment->course;
                $completedMaterials = MaterialCompletion::where('user_id', $studentId)
                    ->whereIn('material_id', $course->materials()->pluck('id'))
                    ->count();

                $progress = $course->materials_count > 0
                    ? round(($completedMaterials / $course->materials_count) * 100, 2)
                    : 0;

                return [
                    'course_id' => $course->id,
                    'course_code' => $course->code,
                    'course_title' => $course->title,
                    'teacher_name' => $course->teacher->user->name ?? 'Tidak tersedia',
                    'thumbnail' => $course->thumbnail ? asset('storage/' . $course->thumbnail) : null,
                    'start_date' => $course->start_date,
                    'end_date' => $course->end_date,
                    'progress' => $progress,
                    'enrolled_at' => $enrollment->enrolled_at,
                ];
            });
    }
}

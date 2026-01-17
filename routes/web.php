<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\ModuleController;
use App\Http\Controllers\Siswa\LessonController;
use App\Http\Controllers\Siswa\QuizController;
use App\Http\Controllers\Siswa\ProfileController;
use App\Http\Controllers\Siswa\TaskSubmissionController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Siswa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('siswa')->group(function () {

    /**
     * =====================
     * DASHBOARD
     * =====================
     */
    Route::get('/dashboard', [ModuleController::class, 'dashboard'])
        ->name('siswa.dashboard');

    /**
     * =====================
     * LESSON
     * =====================
     */
    Route::get('/modul/{lesson}', [LessonController::class, 'show'])
        ->name('siswa.modul.show');

    Route::post('/modul/{lesson}/selesai', [LessonController::class, 'markAsCompleted'])
        ->name('siswa.modul.selesai');

    /**
     * =====================
     * QUIZ
     * =====================
     */
    Route::get('/quiz/{quiz}', [QuizController::class, 'intro'])
        ->name('siswa.quiz.intro');

    Route::get('/quiz/{quiz}/start', [QuizController::class, 'start'])
        ->name('siswa.quiz.start');

    Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])
        ->name('siswa.quiz.submit');

    Route::get('/quiz/{quiz}/result', [QuizController::class, 'result'])
        ->name('siswa.quiz.result');

    /**
     * =====================
     * PROFILE
     * =====================
     */
    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('siswa.profile.update');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('siswa.profile.photo');

    /**
     * =====================
     * LESSON DURATION
     * =====================
     */
    Route::post('/lesson/{lesson}/duration',
        [LessonController::class, 'storeDuration']
    )->name('siswa.lesson.duration');

    /**
     * =====================
     * TASK SUBMISSION (LINK)
     * =====================
     */
    Route::post('/task/{task}/submit',
        [TaskSubmissionController::class, 'store']
    )->name('siswa.task.submit');

     Route::get('/task/{task}', [TaskSubmissionController::class, 'show'])
     ->name('siswa.task.show');


});

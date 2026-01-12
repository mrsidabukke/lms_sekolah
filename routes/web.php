<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\ModuleController;
use App\Http\Controllers\Siswa\LessonController;
use App\Http\Controllers\Siswa\QuizController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\MaterialController;
use App\Http\Controllers\Teacher\AssignmentController;

// Routes Tugas
Route::get('/tugas', [AssignmentController::class, 'index'])->name('guru.tugas.index');
Route::get('/tugas/create', [AssignmentController::class, 'create'])->name('guru.tugas.create');
Route::post('/tugas', [AssignmentController::class, 'store'])->name('guru.tugas.store');
Route::get('/tugas/{id}', [AssignmentController::class, 'show'])->name('guru.tugas.show'); // Untuk detail & penilaian

Route::prefix('guru')->group(function () {
    
    // Routes Materi
    Route::get('/materi', [MaterialController::class, 'index'])->name('guru.materi.index');
    Route::get('/materi/create', [MaterialController::class, 'create'])->name('guru.materi.create');
    Route::post('/materi', [MaterialController::class, 'store'])->name('guru.materi.store');
});

Route::get('/guru/dashboard', [DashboardController::class, 'index'])->name('guru.dashboard');

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
| Auth routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Siswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('siswa')
    ->as('siswa.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [ModuleController::class, 'dashboard'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Lesson / Modul
        |--------------------------------------------------------------------------
        */
        Route::get('/modul/{lesson}', [LessonController::class, 'show'])
            ->name('modul.show');

        Route::post('/modul/{lesson}/selesai',
            [LessonController::class, 'markAsCompleted']
        )->name('modul.selesai');

        /*
        |--------------------------------------------------------------------------
        | Quiz
        |--------------------------------------------------------------------------
        */
        Route::get('/quiz/{quiz}', [QuizController::class, 'show'])
            ->name('quiz.show');

        Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])
            ->name('quiz.submit');
    });

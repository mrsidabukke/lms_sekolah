<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\ModuleController;
use App\Http\Controllers\Siswa\LessonController;
use App\Http\Controllers\Siswa\QuizController;

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

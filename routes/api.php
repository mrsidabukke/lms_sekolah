<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Student LMS
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum', 'student'])->group(function () {
    // Student profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto']);

    // Dashboard & courses
    Route::get('/dashboard', [StudentController::class, 'dashboard']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll']);

    // Course materials
    Route::get('/courses/{course}/materials', [MaterialController::class, 'index']);
    Route::get('/materials/{material}', [MaterialController::class, 'show']);
    Route::post('/materials/{material}/complete', [MaterialController::class, 'markAsCompleted']);
    Route::post('/materials/{material}/duration', [MaterialController::class, 'storeDuration']);

    // Quizzes
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show']);
    Route::get('/quizzes/{quiz}/intro', [QuizController::class, 'intro']);
    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start']);
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);
    Route::get('/quizzes/{quiz}/result', [QuizController::class, 'result']);

    // Tasks/Assignments
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit']);
    Route::get('/tasks/{task}/submission', [TaskController::class, 'getSubmission']);

    // Progress tracking
    Route::get('/progress', [StudentController::class, 'progress']);
    Route::get('/grades', [StudentController::class, 'grades']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

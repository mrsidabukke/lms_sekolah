<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});

Route::post('/login', [AuthController::class, 'login']);

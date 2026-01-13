<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AdminController::class, 'login']);
Route::post('/register-guru', [AdminController::class, 'registerGuru']);
Route::post('/register-siswa', [AdminController::class, 'registerSiswa']);

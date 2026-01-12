<?php

use App\Http\Controllers\AdminController;

Route::post('/login', [AdminController::class, 'login']);

Route::post('/guru', [AdminController::class, 'createGuru']);
Route::get('/guru', [AdminController::class, 'getGuru']);
Route::delete('/guru/{id}', [AdminController::class, 'deleteGuru']);

Route::post('/siswa', [AdminController::class, 'createSiswa']);
Route::get('/siswa', [AdminController::class, 'getSiswa']);
Route::delete('/siswa/{id}', [AdminController::class, 'deleteSiswa']);

<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});

Route::prefix('guru')->group(function () {
    require __DIR__.'/guru.php';
});

Route::prefix('siswa')->group(function () {
    require __DIR__.'/siswa.php';
});

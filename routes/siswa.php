<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [SiswaController::class, 'login']);

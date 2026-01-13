<?php

use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [GuruController::class, 'login']);

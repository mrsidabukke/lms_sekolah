<?php

use App\Http\Controllers\SiswaController;

Route::post('/login', [SiswaController::class, 'login']);

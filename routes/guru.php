<?php

use App\Http\Controllers\GuruController;

Route::post('/login', [GuruController::class, 'login']);

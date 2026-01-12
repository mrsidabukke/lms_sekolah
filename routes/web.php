<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Include file api_connect.php
require __DIR__.'/api_connect.php';

<?php

use Illuminate\Support\Facades\Route;

Route::get('/api-connect', function () {
    try {
        return '<span style="color:green">API Laravel siap digunakan!</span>';
    } catch (\Exception $e) {
        return '<span style="color:red">API error: ' . $e->getMessage() . '</span>';
    }
});

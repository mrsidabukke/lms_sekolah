<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function show($task)
    {
        return response()->json([]);
    }

    public function submit($task)
    {
        return response()->json(['message' => 'Submitted']);
    }

    public function getSubmission($task)
    {
        return response()->json([]);
    }
}

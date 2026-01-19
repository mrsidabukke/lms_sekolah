<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(['courses' => []]);
    }

    public function show($course)
    {
        return response()->json(['course' => $course]);
    }

    public function enroll($course)
    {
        return response()->json(['message' => 'Enrolled']);
    }
}

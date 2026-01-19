<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    public function index($course)
    {
        return response()->json(['materials' => []]);
    }

    public function show($material)
    {
        return response()->json(['material' => $material]);
    }

    public function markAsCompleted($material)
    {
        return response()->json(['message' => 'Completed']);
    }

    public function storeDuration($material)
    {
        return response()->json(['message' => 'Duration saved']);
    }
}

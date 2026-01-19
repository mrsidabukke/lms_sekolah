<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        return response()->json([
            'message' => 'Profile updated (dummy)'
        ]);
    }

    public function changePassword(Request $request)
    {
        return response()->json([
            'message' => 'Password changed (dummy)'
        ]);
    }

    public function updatePhoto(Request $request)
    {
        return response()->json([
            'message' => 'Photo updated (dummy)'
        ]);
    }
}

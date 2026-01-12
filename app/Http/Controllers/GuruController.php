<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function login(Request $request)
    {
        $guru = Guru::where('username', $request->username)->first();

        if (!$guru || !Hash::check($request->password, $guru->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'data' => $guru
        ]);
    }
}

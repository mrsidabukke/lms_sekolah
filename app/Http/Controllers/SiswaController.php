<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('role', 'siswa')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        return response()->json([
            'message' => 'Login siswa berhasil',
            'user' => $user
        ]);
    }
}

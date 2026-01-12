<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function login(Request $request)
    {
        $siswa = Siswa::where('username', $request->username)->first();

        if (!$siswa || !Hash::check($request->password, $siswa->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'data' => $siswa
        ]);
    }
}

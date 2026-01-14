<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ]);

        $user = User::where('identifier', $request->identifier)->first();

        if (!$user) {
            return response()->json([
                'status' => 'login gagal',
                'message' => 'user tidak ditemukan'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'login gagal',
                'message' => 'password salah'
            ], 401);
        }

        if ($user->role === 'teacher') {
            return response()->json([
                'status' => 'Login berhasil',
                'teacher' => [
                    'id'    => $user->teacher->id,
                    'name'  => $user->teacher->name,
                    'nip'   => $user->teacher->nip,
                    'mapel' => $user->teacher->mapel,
                    'role'  => 'teacher'
                ]
            ]);
        }

        if ($user->role === 'student') {
            return response()->json([
                'status' => 'Login berhasil',
                'student' => [
                    'id'          => $user->student->id,
                    'name'        => $user->student->name,
                    'nisn'        => $user->student->nisn,
                    'foto'        => $user->student->foto,
                    'jurusan'     => $user->student->jurusan,
                    'class_level' => $user->student->class_level,
                    'role'        => 'student'
                ]
            ]);
        }
    }
}

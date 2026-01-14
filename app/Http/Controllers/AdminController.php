<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ======================
    // LOGIN ADMIN
    // ======================
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password'   => 'required'
        ]);

        // role admin ditentukan sistem
        if ($request->identifier !== 'admin') {
            return response()->json(['message' => 'Bukan akun admin'], 403);
        }

        $user = User::where('identifier', 'admin')
                    ->where('role', 'admin')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        return response()->json([
            'message' => 'Admin berhasil login',
            'data' => [
                'identifier' => $user->identifier,
                'role' => $user->role
            ]
        ]);
    }

    // ======================
    // REGISTER GURU (ADMIN)
    // ======================
    public function registerGuru(Request $request)
{
    $request->validate([
        'name'       => 'required|string',
        'identifier' => 'required|string|unique:users,identifier',
        'password'   => 'required|min:4'
    ]);

    DB::transaction(function () use ($request) {

        $user = User::create([
            'name'       => $request->name,
            'identifier' => $request->identifier,
            'password'   => Hash::make($request->password),
            'role'       => 'guru'
        ]);

        Guru::create([
            'name'    => $request->name,
            'nip'     => $request->identifier,
            'id_user' => $user->id
        ]);
    });

    return response()->json([
        'message' => "Akun guru berhasil dibuat"
    ], 201);
}

    // ======================
    // REGISTER SISWA (ADMIN)
    // ======================
    public function registerSiswa(Request $request)
{
    $request->validate([
        'name'       => 'required|string',
        'identifier' => 'required|string|unique:users,identifier',
        'password'   => 'required|min:4'
    ]);

    DB::transaction(function () use ($request) {

        $user = User::create([
            'name'       => $request->name, // 🔥 INI YANG HILANG
            'identifier' => $request->identifier,
            'password'   => Hash::make($request->password),
            'role'       => 'siswa'
        ]);

        Siswa::create([
            'name'    => $request->name,
            'nisn'    => $request->identifier,
            'id_user' => $user->id
        ]);
    });

    return response()->json([
        'message' => "Akun siswa berhasil dibuat"
    ], 201);
}

}

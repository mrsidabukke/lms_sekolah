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

        // ambil user berdasarkan identifier
        $user = User::where('identifier', $request->identifier)->first();

        if (!$user) {
            return response()->json([
                'status' => 'login gagal',
                'message' => 'user tidak ditemukan'
            ], 404);
        }

        // cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'login gagal',
                'message' => 'password salah'
            ], 401);
        }

        // ambil nama sesuai role
        $name = match ($user->role) {
            'admin' => optional($user->admin)->name ?? 'administrator',
            'guru'  => optional($user->guru)->name,
            'siswa' => optional($user->siswa)->name,
            default => 'user',
        };

        // ambil identifier tambahan (nip / nisn / admin)
        $extraIdentifier = match ($user->role) {
            'guru'  => optional($user->guru)->nip,
            'siswa' => optional($user->siswa)->nisn,
            'admin' => $user->identifier,
            default => null,
        };

        return response()->json([
            'status' => 'user berhasil login',
            'user' => [
                'role' => $user->role,
            ],
            'nama' => strtolower($name),
            'nip'  => $extraIdentifier
        ]);
    }
}

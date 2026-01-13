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
            'identifier' => 'required',
            'password'   => 'required'
        ]);

        // tentukan role otomatis
        if ($request->identifier === 'admin') {
            $role = 'admin';
        } else {
            $userTemp = User::where('identifier', $request->identifier)->first();
            if (!$userTemp) {
                return response()->json(['message' => 'User tidak ditemukan'], 404);
            }
            $role = $userTemp->role;
        }

        $user = User::where('identifier', $request->identifier)
                    ->where('role', $role)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        $name = match ($role) {
            'admin' => $user->admin->name ?? 'Admin',
            'guru'  => $user->guru->name,
            'siswa' => $user->siswa->name,
        };

        return response()->json([
            'message' => "{$role} {$name} berhasil login",
            'data' => [
                'identifier' => $user->identifier,
                'role' => $role,
                'name' => $name
            ]
        ]);
    }
}

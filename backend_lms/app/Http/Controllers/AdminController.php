<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'data' => $admin
        ]);
    }

    // CRUD GURU
    public function createGuru(Request $request)
    {
        return Guru::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
    }

    public function getGuru()
    {
        return Guru::all();
    }

    public function deleteGuru($id)
    {
        Guru::findOrFail($id)->delete();
        return response()->json(['message' => 'Guru dihapus']);
    }

    // CRUD SISWA
    public function createSiswa(Request $request)
    {
        return Siswa::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
    }

    public function getSiswa()
    {
        return Siswa::all();
    }

    public function deleteSiswa($id)
    {
        Siswa::findOrFail($id)->delete();
        return response()->json(['message' => 'Siswa dihapus']);
    }
}

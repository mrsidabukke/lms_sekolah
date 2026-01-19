<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login siswa/guru
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'password' => 'required|string',
            'device_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari user berdasarkan identifier (NISN/NIP) atau email
        $user = User::where('identifier', $request->identifier)
            ->orWhere('email', $request->identifier)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun tidak ditemukan'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun tidak aktif. Silakan hubungi admin.'
            ], 403);
        }

        // Buat token Sanctum
        $token = $user->createToken($request->device_name ?? 'web')->plainTextToken;

        // Get user data based on role
        $userData = $this->getUserData($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $userData
        ]);
    }

    /**
     * Forgot password
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan'
            ], 404);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => 'Link reset password telah dikirim ke email Anda'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengirim link reset password'
        ], 500);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil direset'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Token reset password tidak valid'
        ], 400);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get user data based on role
     */
    private function getUserData(User $user)
    {
        $baseData = [
            'id' => $user->id,
            'identifier' => $user->identifier,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'photo' => $user->photo ? asset('storage/' . $user->photo) : null,
            'department_id' => $user->department_id,
            'is_active' => $user->is_active,
            'created_at' => $user->created_at,
        ];

        if ($user->isStudent()) {
            $student = $user->student;
            $baseData['student'] = [
                'id' => $student->id,
                'nisn' => $student->nisn,
                'jurusan' => $student->jurusan,
                'class_level' => $student->class_level,
                'phone' => $student->phone,
                'address' => $student->address,
                'birth_date' => $student->birth_date?->format('Y-m-d'),
                'birth_place' => $student->birth_place,
                'gender' => $student->gender,
                'religion' => $student->religion,
            ];
        } elseif ($user->isTeacher()) {
            $teacher = $user->teacher;
            $baseData['teacher'] = [
                'id' => $teacher->id,
                'nip' => $teacher->nip,
                'mapel' => $teacher->mapel,
                'expertise' => $teacher->expertise,
            ];
        }

        return $baseData;
    }
}

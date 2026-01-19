<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * =========================
     * UPDATE FOTO PROFIL SISWA
     * =========================
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        /**
         * =========================
         * HAPUS FOTO LAMA (JIKA ADA)
         * =========================
         */
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        /**
         * =========================
         * SIMPAN FOTO BARU
         * =========================
         */
        $path = $request->file('photo')
            ->store('profile-photos', 'public');

        /**
         * =========================
         * SIMPAN KE DATABASE
         * =========================
         */
        $user->update([
            'photo' => $path,
        ]);

        return back()->with('success', '✅ Foto profil berhasil diperbarui');
    }
}

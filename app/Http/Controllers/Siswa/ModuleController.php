<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
     public function dashboard()
    {
        $user = Auth::user();

        /**
         * =========================
         * SEMUA JURUSAN (DINAMIS)
         * =========================
         */
        $departments = Department::with('modules')->get();

        /**
         * =========================
         * MODULE MILIK SISWA
         * =========================
         */
        $myModules = Module::where('department_id', $user->department_id)
            ->where('is_active', true)
            ->with('lessons')
            ->get();

        return view('siswa.dashboard', [
            'user'        => $user,
            'departments'=> $departments,
            'myModules'  => $myModules, // ⬅️ INI YANG TADI HILANG
        ]);
    }
}

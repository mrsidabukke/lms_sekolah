<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        /**
         * =========================
         * AMBIL SEMUA MODULE AKTIF
         * =========================
         */
        $allModules = Module::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        /**
         * =========================
         * GROUP BY DEPARTMENT
         * =========================
         */
        $departments = $allModules->groupBy('department_id');

        /**
         * =========================
         * LABEL JURUSAN
         * (bisa nanti pindah ke table departments)
         * =========================
         */
        $departmentLabels = [
            1 => 'Teknik Mesin',
            2 => 'Teknik Elektro',
            3 => 'Teknik Informatika',
            4 => 'Akuntansi',
            5 => 'Bisnis Digital',
        ];

        return view('siswa.dashboard', [
            'user'             => $user,
            'departments'      => $departments,
            'departmentLabels' => $departmentLabels,
        ]);
    }
}

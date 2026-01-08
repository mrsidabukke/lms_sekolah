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

        $modules = Module::where('is_active', true)
            ->where('department_id', $user->department_id)
            ->get();

        return view('siswa.dashboard', compact('modules'));
    }
}

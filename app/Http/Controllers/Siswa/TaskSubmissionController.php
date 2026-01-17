<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller
{
    /**
     * ===============================
     * HALAMAN PENGUMPULAN TUGAS (SISWA)
     * ===============================
     */
    public function show(Task $task)
    {
        $user = auth()->user();

        // ================= TASK AKTIF =================
        if (! $task->is_active) {
            abort(403, 'Tugas tidak aktif');
        }

        // ================= LOCK: LESSON HARUS SELESAI =================
        $lessonCompleted = $task->lesson
            ->users()
            ->where('user_id', $user->id)
            ->where('is_completed', true)
            ->exists();

        if (! $lessonCompleted) {
            return redirect()
                ->route('siswa.modul.show', $task->lesson_id)
                ->with('error', 'Selesaikan materi terlebih dahulu.');
        }

        // ================= AMBIL SUBMISSION (JIKA ADA) =================
        $submission = TaskSubmission::where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->first();

        return view('siswa.task.show', [
            'task' => $task,
            'submission' => $submission,
        ]);
    }

    /**
     * ===============================
     * SIMPAN / UPDATE SUBMISSION
     * ===============================
     */
    public function store(Request $request, Task $task)
    {
        // ================= VALIDASI INPUT =================
        $request->validate([
            'submission_link' => 'required|url|max:2048',
            'note' => 'nullable|string|max:1000',
        ]);

        $userId = auth()->id();

        // ================= TASK AKTIF =================
        if (! $task->is_active) {
            abort(403, 'Tugas tidak aktif');
        }

        // ================= DEADLINE =================
        if ($task->deadline && now()->greaterThan($task->deadline)) {
            return back()->withErrors([
                'submission_link' => 'Deadline tugas telah berakhir'
            ]);
        }

        // ================= CEK SUBMISSION LAMA =================
        $existingSubmission = TaskSubmission::where('task_id', $task->id)
            ->where('user_id', $userId)
            ->first();

        // ================= ALLOW REVISION =================
        if ($existingSubmission && ! $task->allow_revision) {
            abort(403, 'Tugas tidak boleh direvisi');
        }

        // ================= SIMPAN =================
        TaskSubmission::updateOrCreate(
            [
                'task_id' => $task->id,
                'user_id' => $userId,
            ],
            [
                'submission_link' => $request->submission_link,
                'note' => $request->note,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        return redirect()
            ->route('siswa.modul.show', $task->lesson_id)
            ->with('success', '✅ Tugas berhasil dikirim');
    }
}

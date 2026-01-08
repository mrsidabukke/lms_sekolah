<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Tampilkan quiz / hasil quiz
     */
    public function show(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        $attempt = $quiz->users()
            ->where('user_id', $user->id)
            ->first();

        /**
         * ==========================
         * MODE ULANG QUIZ (?retry=1)
         * ==========================
         */
        if ($request->query('retry') == 1) {
            // hapus attempt lama (lulus / tidak)
            $user->quizzes()->detach($quiz->id);

            $questions = $quiz->questions;
            return view('siswa.quiz.show', compact('quiz', 'questions'));
        }

        /**
         * ==========================
         * JIKA SUDAH PERNAH MENGERJAKAN
         * → tampilkan hasil
         * ==========================
         */
        if ($attempt) {
            return view('siswa.quiz.result', [
                'quiz'     => $quiz,
                'score'    => $attempt->pivot->score,
                'isPassed' => $attempt->pivot->is_passed,
            ]);
        }

        /**
         * ==========================
         * JIKA BELUM PERNAH
         * ==========================
         */
        $questions = $quiz->questions;
        return view('siswa.quiz.show', compact('quiz', 'questions'));
    }

    /**
     * Submit quiz & hitung nilai
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        abort_if($quiz->questions->isEmpty(), 404, 'Quiz belum memiliki soal');

        $questions = $quiz->questions;
        $correct = 0;

        foreach ($questions as $question) {
            $answer = $request->input('answers.' . $question->id);
            if ($answer === $question->correct_option) {
                $correct++;
            }
        }

        $score  = round(($correct / max($questions->count(), 1)) * 100);
        $passed = $score >= $quiz->passing_score;

        /**
         * Simpan hasil quiz
         */
        $user->quizzes()->syncWithoutDetaching([
            $quiz->id => [
                'score'     => $score,
                'is_passed' => $passed,
            ],
        ]);

        /**
         * Jika lulus → buka lesson (sekali saja, aman)
         */
        if ($passed && $quiz->lesson_id) {
            $user->lessons()->syncWithoutDetaching([
                $quiz->lesson_id => ['is_completed' => true],
            ]);
        }

        return redirect()->route('siswa.quiz.show', $quiz->id);
    }
}

<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function intro(Quiz $quiz)
    {
        return view('siswa.quiz.intro', compact('quiz'));
    }

    public function start(Quiz $quiz)
    {
        $user = Auth::user();

        // reset attempt lama
        $user->quizzes()->detach($quiz->id);

        abort_if($quiz->questions->isEmpty(), 404);

        return view('siswa.quiz.start', [
            'quiz'      => $quiz,
            'questions' => $quiz->questions,
            'duration'  => $quiz->duration, // ⏱️ KIRIM KE VIEW
        ]);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $correct = 0;

        foreach ($quiz->questions as $question) {
            if (
                $request->input("answers.$question->id") ===
                $question->correct_option
            ) {
                $correct++;
            }
        }

        $score  = round(($correct / max($quiz->questions->count(), 1)) * 100);
        $passed = $score >= $quiz->passing_score;

        $user->quizzes()->syncWithoutDetaching([
            $quiz->id => [
                'score'     => $score,
                'is_passed' => $passed,
            ],
        ]);

        if ($passed && $quiz->lesson_id) {
            $user->lessons()->syncWithoutDetaching([
                $quiz->lesson_id => ['is_completed' => true],
            ]);
        }

        return redirect()->route('siswa.quiz.result', $quiz->id);
    }

    public function result(Quiz $quiz)
    {
        $user = Auth::user();

        $attempt = $quiz->users()
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('siswa.quiz.result', [
            'quiz'     => $quiz,
            'score'    => $attempt->pivot->score,
            'isPassed' => $attempt->pivot->is_passed,
        ]);
    }
}

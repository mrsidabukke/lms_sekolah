<?php

namespace App\Imports;

use App\Models\QuizQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Agar baris 1 dianggap header

class QuestionsImport implements ToModel, WithHeadingRow
{
    protected $quiz_id;

    public function __construct($quiz_id)
    {
        $this->quiz_id = $quiz_id;
    }

    public function model(array $row)
    {
        // Pastikan nama header di Excel (lowercase) sesuai dengan key array ini
        return new QuizQuestion([
            'quiz_id'        => $this->quiz_id,
            'type'           => 'multiple_choice',
            'question'       => $row['pertanyaan'],
            'option_a'       => $row['opsi_a'],
            'option_b'       => $row['opsi_b'],
            'option_c'       => $row['opsi_c'],
            'option_d'       => $row['opsi_d'],
            'correct_option' => strtolower($row['kunci_jawaban']), // a, b, c, atau d
            'correct_answer' => $row['opsi_' . strtolower($row['kunci_jawaban'])] ?? 'Error',
        ]);
    }
}
@extends('siswa.layout')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow">

    <h1 class="text-2xl font-bold mb-6 text-gray-900">
        Aturan
    </h1>

    <p class="text-lg font-semibold mb-4">
        {{ $quiz->title }}
    </p>

    <ul class="space-y-3 text-gray-700 mb-8">

        <li class="flex items-center gap-2">
            <span>🎯</span>
            <span>
                Syarat kelulusan:
                <strong>{{ $quiz->passing_score }}%</strong>
            </span>
        </li>

        <li class="flex items-center gap-2">
            <span>❓</span>
            <span>
                Jumlah soal:
                <strong>{{ $quiz->questions->count() }}</strong>
            </span>
        </li>

        <li class="flex items-center gap-2">
            <span>⏱️</span>
            <span>
                Durasi:
                <strong>
                    @if($quiz->duration)
                        {{ $quiz->duration }} menit
                    @else
                        Tidak dibatasi
                    @endif
                </strong>
            </span>
        </li>

    </ul>

    <div class="flex justify-between items-center">

        <a href="{{ route('siswa.modul.show', $quiz->lesson_id) }}"
           class="text-gray-500 hover:text-black text-sm">
            ← Kembali ke materi
        </a>

        <a href="{{ route('siswa.quiz.start', $quiz->id) }}"
           class="bg-teal-600 text-white px-8 py-3 rounded-lg
                  hover:bg-teal-500 transition font-semibold">
            Mulai
        </a>

    </div>

</div>

@endsection

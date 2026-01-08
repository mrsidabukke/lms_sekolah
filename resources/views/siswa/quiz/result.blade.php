@extends('siswa.layout')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-4">
        Hasil Quiz: {{ $quiz->title }}
    </h1>

    <div class="mb-6">
        <p class="text-lg">
            Nilai kamu:
            <span class="font-bold {{ $isPassed ? 'text-green-600' : 'text-red-600' }}">
                {{ $score }}
            </span>
        </p>

        @if($isPassed)
            <p class="text-green-600 mt-2 font-semibold">
                ✅ Selamat, kamu LULUS!
            </p>
        @else
            <p class="text-red-600 mt-2 font-semibold">
                ❌ Kamu belum lulus. Silakan pelajari materi lagi. Lalu kerjakan ulang
            </p>
        @endif
    </div>

    <div class="flex gap-4">
        <a href="{{ route('siswa.dashboard') }}"
           class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
            Kembali ke Dashboard
        </a>

        @if(!$isPassed)
            <a href="{{ route('siswa.quiz.show', [$quiz->id, 'retry' => 1]) }}"
               class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-500">
                Kerjakan Ulang Quiz
            </a>
        @endif
    </div>

</div>
@endsection

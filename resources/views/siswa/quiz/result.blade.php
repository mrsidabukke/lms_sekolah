@extends('siswa.layout')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-4">
        Hasil Quiz: {{ $quiz->title }}
    </h1>

    <p class="text-lg mb-4">
        Nilai kamu:
        <span class="{{ $isPassed ? 'text-green-600' : 'text-red-600' }} font-bold">
            {{ $score }}
        </span>
    </p>

    @if($isPassed)
        <p class="text-green-600 mb-6 font-semibold">
            ✅ Selamat, kamu lulus!
        </p>
    @else
        <p class="text-red-600 mb-6 font-semibold">
            ❌ Belum lulus, silakan ulangi.
        </p>
    @endif

    <div class="flex gap-4">
        <a href="{{ route('siswa.dashboard') }}"
           class="px-6 py-3 bg-gray-700 text-white rounded-lg">
            Dashboard
        </a>

    <a href="{{ route('siswa.quiz.intro', $quiz->id) }}"
   class="px-6 py-3 bg-blue-600 text-white rounded-lg">
    Kerjakan Ulang Quiz
</a>




        @if($isPassed && $quiz->lesson_id)
            <a href="{{ route('siswa.modul.show', $quiz->lesson_id) }}"
               class="px-6 py-3 bg-green-600 text-white rounded-lg">
                Lanjut Materi →
            </a>
        @endif
    </div>

</div>
@endsection

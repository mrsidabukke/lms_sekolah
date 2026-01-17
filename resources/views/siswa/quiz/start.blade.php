@extends('siswa.layout')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-8">

    <!-- HEADER -->
    <div class="mb-6 border-b pb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $quiz->title }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Nilai minimum lulus: {{ $quiz->passing_score }}%
            </p>
        </div>

        {{-- ⏱️ TIMER --}}
        @if($quiz->duration)
            <div class="text-red-600 font-bold text-lg">
                ⏱️ <span id="quiz-timer">00:00</span>
            </div>
        @endif
    </div>

    <!-- QUIZ FORM -->
    <form id="quiz-form"
          method="POST"
          action="{{ route('siswa.quiz.submit', $quiz->id) }}">
        @csrf

        <div class="space-y-8">

            @foreach($questions as $index => $question)
                <div class="border rounded-xl p-6">

                    <!-- QUESTION -->
                    <p class="font-semibold text-gray-800 mb-4">
                        {{ $index + 1 }}. {{ $question->question }}
                    </p>

                    <!-- OPTIONS -->
                    <div class="space-y-3 text-gray-700">

                        @foreach(['a','b','c','d'] as $opt)
                            @php $field = 'option_'.$opt; @endphp

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input
                                    type="radio"
                                    name="answers[{{ $question->id }}]"
                                    value="{{ $opt }}"
                                    class="text-gray-900 focus:ring-gray-800"
                                >
                                <span>
                                    <strong>{{ strtoupper($opt) }}.</strong>
                                    {{ $question->$field }}
                                </span>
                            </label>
                        @endforeach

                    </div>
                </div>
            @endforeach

        </div>

        <!-- SUBMIT -->
        <div class="flex justify-end mt-10">
            <button
                type="submit"
                class="bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition">
                Kirim Jawaban
            </button>
        </div>

    </form>

</div>

{{-- ================= TIMER SCRIPT ================= --}}
@if($quiz->duration)
<script>
document.addEventListener('DOMContentLoaded', () => {

    let remaining = {{ $quiz->duration }} * 60; // menit → detik
    const timerEl = document.getElementById('quiz-timer');
    const form = document.getElementById('quiz-form');

    const tick = () => {
        const min = Math.floor(remaining / 60);
        const sec = remaining % 60;

        timerEl.textContent =
            String(min).padStart(2, '0') + ':' +
            String(sec).padStart(2, '0');

        remaining--;

        if (remaining < 0) {
            clearInterval(interval);
            alert('⏰ Waktu habis! Jawaban akan dikirim otomatis.');
            form.submit(); // 🔥 AUTO SUBMIT
        }
    };

    tick(); // render awal
    const interval = setInterval(tick, 1000);
});
</script>
@endif

@endsection

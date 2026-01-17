@extends('siswa.layout')

@section('content')

<div x-data="{ sidebarOpen: true }" class="bg-white rounded-2xl shadow overflow-hidden">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <div class="flex items-center gap-3">
            <a href="{{ route('siswa.dashboard') }}"
               class="text-gray-500 hover:text-black text-lg">←</a>

            <h1 class="font-semibold text-lg text-gray-800">
                {{ $lesson->title }}
            </h1>
        </div>

        <button @click="sidebarOpen = !sidebarOpen"
                class="text-gray-600 hover:text-black text-xl">☰</button>
    </div>

    <!-- MAIN -->
    <div class="flex min-h-[75vh]">

        <!-- CONTENT -->
        <section class="flex-1 p-10">

            <h2 class="text-3xl font-bold mb-6 text-gray-900">
                {{ $lesson->title }}
            </h2>

            {{-- ================= CONTENT ================= --}}
            <div class="mb-10">

                {{-- TEXT --}}
                @if($lesson->content_type === 'text')
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($lesson->content)) !!}
                    </div>

                {{-- PDF --}}
                @elseif($lesson->content_type === 'pdf')
                    <iframe
                        src="{{ str_replace('/view', '/preview', $lesson->content_url) }}"
                        class="w-full h-[600px] border rounded-xl">
                    </iframe>

                {{-- VIDEO --}}
                @elseif($lesson->content_type === 'video')
                    @php
                        $isYoutube =
                            str_contains($lesson->content_url, 'youtube') ||
                            str_contains($lesson->content_url, 'youtu.be');

                        if ($isYoutube) {
                            preg_match('/(youtu\.be\/|v=)([^&]+)/', $lesson->content_url, $m);
                            $videoId = $m[2] ?? null;
                            $videoUrl = $videoId
                                ? 'https://www.youtube.com/embed/'.$videoId.'?controls=0&rel=0'
                                : null;
                        } else {
                            $videoUrl = str_replace('/view', '/preview', $lesson->content_url);
                        }
                    @endphp

                    @if($videoUrl)
                        <iframe
                            src="{{ $videoUrl }}"
                            class="w-full h-[450px] rounded-xl"
                            allow="autoplay; encrypted-media"
                            allowfullscreen>
                        </iframe>
                    @else
                        <p class="text-red-600">Video tidak valid</p>
                    @endif

                {{-- LINK --}}
                @elseif($lesson->content_type === 'link')
                    <a href="{{ $lesson->content_url }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                        🔗 Buka Materi
                    </a>
                @endif

            </div>

            {{-- ================= TASK ================= --}}
            @if(isset($task))
            <div
                id="task-{{ $task->id }}"
                class="mt-16 p-6 border-2 border-blue-400 rounded-2xl bg-blue-50 scroll-mt-24"
            >

                <h3 class="text-xl font-semibold mb-2">
                    📌 Tugas
                </h3>

                <p class="text-gray-700 mb-4">
                    {{ $task->description }}
                </p>

                <p class="text-sm text-gray-500 mb-6">
                    ⏰ Deadline:
                    <span class="font-semibold">
                        {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y H:i') }}
                    </span>
                </p>

                {{-- SUDAH SUBMIT --}}
                @if($isTaskCompleted)

                    <div class="p-4 rounded-lg bg-green-50 border border-green-200">
                        <p class="text-green-700 font-semibold">
                            ✓ Tugas sudah dikumpulkan
                        </p>

                        <p class="text-sm text-gray-600 mt-2 break-all">
                            🔗 {{ $taskSubmission->submission_link }}
                        </p>

                        @if($task->allow_revision)
                            <p class="text-sm text-yellow-600 mt-2">
                                Revisi diperbolehkan
                            </p>
                        @endif
                    </div>

                {{-- BELUM SUBMIT --}}
                @else

                    <form method="POST"
                          action="{{ route('siswa.task.submit', $task->id) }}"
                          class="space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm font-medium text-gray-700">
                                Link Tugas
                            </label>
                            <input
                                type="url"
                                name="submission_link"
                                required
                                placeholder="https://drive.google.com/..."
                                class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">
                                Catatan (opsional)
                            </label>
                            <textarea
                                name="note"
                                rows="3"
                                class="w-full mt-1 px-4 py-2 border rounded-lg"
                                placeholder="Penjelasan singkat tugas..."
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-500">
                            Kirim Tugas
                        </button>
                    </form>

                @endif
            </div>
            @endif

            {{-- ================= ACTION BAR ================= --}}
            <div class="flex justify-between items-center mt-16">

                <div>
                    @if($isCompleted)
                        <span class="text-green-600 font-semibold">
                            ✓ Materi telah diselesaikan
                        </span>
                    @endif
                </div>

                <div class="flex gap-4">

                    @if(!$isCompleted)
                        <form id="form-selesai"
                              method="POST"
                              action="{{ route('siswa.modul.selesai', $lesson->id) }}">
                            @csrf
                            <button
                                id="btn-selesai"
                                @if(($lesson->duration ?? 0) > 0) disabled @endif
                                class="bg-gray-900 text-white px-6 py-3 rounded-lg
                                       hover:bg-gray-700 transition
                                       disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Tandai Selesai
                            </button>
                        </form>

                    @elseif(isset($task) && ! $isTaskCompleted)
                        <button
                            type="button"
                            onclick="scrollToTask({{ $task->id }})"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500">
                            📤 Kerjakan Tugas →
                        </button>

                    @elseif(isset($nextQuiz))
                        <a href="{{ route('siswa.quiz.intro', $nextQuiz->id) }}"
                           class="bg-yellow-500 text-black px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400">
                            📝 Kerjakan Quiz →
                        </a>

                    @elseif($canGoNext && $nextLesson)
                        <a href="{{ route('siswa.modul.show', $nextLesson->id) }}"
                           class="bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-700">
                            Lanjut ke Materi →
                        </a>

                    @else
                        <button disabled
                            class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg">
                            Materi Terakhir
                        </button>
                    @endif

                </div>
            </div>

        </section>

        {{-- SIDEBAR --}}
        @include('siswa.modul.sidebar')

    </div>
</div>

{{-- ================= SCRIPT DURASI ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const REQUIRED = {{ $lesson->duration ?? 0 }};
    const lessonId = {{ $lesson->id }};
    let seconds = 0;
    let lastActivity = Date.now();

    const btn = document.getElementById('btn-selesai');
    const form = document.getElementById('form-selesai');

    const activity = () => lastActivity = Date.now();
    ['mousemove','scroll','click','keydown'].forEach(e =>
        window.addEventListener(e, activity)
    );

    setInterval(() => {
        if (Date.now() - lastActivity < 10000) {
            seconds++;
            if (REQUIRED > 0 && seconds >= REQUIRED) {
                btn?.removeAttribute('disabled');
            }
        }
    }, 1000);

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();

        await fetch(`/siswa/lesson/${lessonId}/duration`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ seconds })
        });

        form.submit();
    });

});
</script>

{{-- ================= SCROLL TASK (WAJIB) ================= --}}
<script>
function scrollToTask(taskId) {
    const el = document.getElementById('task-' + taskId);
    if (el) {
        el.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}
</script>

@endsection

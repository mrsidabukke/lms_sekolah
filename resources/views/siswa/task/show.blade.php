@extends('siswa.layout')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">

    <a href="{{ route('siswa.modul.show', $task->lesson_id) }}"
       class="text-sm text-gray-500 hover:text-black">← Kembali ke Materi</a>

    <h1 class="text-2xl font-bold mt-4 mb-2">
        📤 {{ $task->title }}
    </h1>

    <p class="text-gray-700 mb-4">
        {{ $task->description }}
    </p>

    <p class="text-sm text-gray-500 mb-6">
        ⏰ Deadline:
        <strong>
            {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y H:i') }}
        </strong>
    </p>

    {{-- ================= FLASH MESSAGE ================= --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- ================= SUDAH SUBMIT ================= --}}
   @if($submission && ! $task->allow_revision)

    {{-- SUDAH SUBMIT & TIDAK BOLEH REVISI --}}
    <div class="p-4 rounded-lg bg-green-50 border border-green-200">
        <p class="text-green-700 font-semibold">
            ✓ Tugas sudah dikumpulkan
        </p>

        <p class="text-sm text-gray-600 mt-2 break-all">
            🔗 {{ $submission->submission_link }}
        </p>

        <p class="text-sm text-gray-500 mt-2">
            Revisi tidak diperbolehkan
        </p>
    </div>

@else

    {{-- BOLEH REVISI / BELUM SUBMIT --}}
    @if($submission)
        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-700 font-semibold">
                🔁 Revisi tugas
            </p>
        </div>
    @endif

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
                value="{{ $submission->submission_link ?? '' }}"
                class="w-full mt-1 px-4 py-2 border rounded-lg"
            >
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">
                Catatan (opsional)
            </label>
            <textarea
                name="note"
                rows="3"
                class="w-full mt-1 px-4 py-2 border rounded-lg">{{ $submission->note ?? '' }}</textarea>
        </div>

        <button
            type="submit"
            class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-500">
            {{ $submission ? 'Kirim Revisi' : 'Kirim Tugas' }}
        </button>
    </form>

@endif

</div>

@endsection

@extends('siswa.layout')

@section('content')

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <div class="flex items-center gap-3">
            <a href="{{ route('siswa.dashboard') }}"
               class="text-gray-500 hover:text-black text-lg">
                ←
            </a>

            <h1 class="font-semibold text-lg text-gray-800">
                {{ $lesson->title }}
            </h1>
        </div>
    </div>

    <!-- MAIN -->
    <div class="flex min-h-[75vh]">

        <!-- CONTENT -->
        <section class="flex-1 p-10">

            <h2 class="text-3xl font-bold mb-4 text-gray-900">
                {{ $lesson->title }}
            </h2>

            <div class="text-gray-600 leading-relaxed mb-12">
                {!! nl2br(e($lesson->content)) !!}
            </div>

            <!-- ACTION BAR -->
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
                        <form method="POST"
                              action="{{ route('siswa.modul.selesai', $lesson->id) }}">
                            @csrf
                            <button
                                class="bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                                Tandai Selesai
                            </button>
                        </form>
                    @elseif($canGoNext && $nextLesson)
                        <a href="{{ route('siswa.modul.show', $nextLesson->id) }}"
                           class="bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                            Lanjut ke Materi Berikutnya →
                        </a>
                    @else
                        <button disabled
                            class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg cursor-not-allowed">
                            Materi Terakhir
                        </button>
                    @endif
                </div>

            </div>
        </section>

        <!-- SIDEBAR -->
        <aside class="w-80 border-l bg-gray-50 p-6 overflow-y-auto">

            <!-- PROGRESS -->
            <p class="text-sm text-gray-500 mb-2">
                Progress Kursus ({{ $progress }}%)
            </p>

            <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                <div class="bg-gray-900 h-2 rounded-full transition-all"
                     style="width: {{ $progress }}%">
                </div>
            </div>

            <!-- SECTION & ITEM LIST -->
            <div class="space-y-6 text-sm">

                @foreach($sections as $section)
                    <div>

                        <!-- SECTION TITLE -->
                        <div class="flex justify-between items-center font-semibold text-gray-800 mb-2">
                            <span>{{ $section->title }}</span>

                            <span class="text-xs text-gray-500">
                                {{ $section->items->where('is_completed', true)->count() }}
                                /
                                {{ $section->items->count() }}
                            </span>
                        </div>

                        <!-- ITEMS (LESSON + QUIZ) -->
                        <ul class="space-y-2 pl-3 border-l border-gray-200">

                            @foreach($section->items as $item)
                                <li class="flex items-center justify-between gap-2">

                                    @if(!$item->is_locked)

                                        {{-- LESSON --}}
                                        @if($item->type === 'lesson')
                                            <a href="{{ route('siswa.modul.show', $item->id) }}"
                                               class="
                                                   flex-1
                                                   @if($item->id === $lesson->id)
                                                       font-semibold text-black
                                                   @elseif($item->is_completed)
                                                       text-green-600
                                                   @else
                                                       text-gray-700
                                                   @endif
                                                   hover:underline
                                               ">
                                                📘 {{ $item->title }}
                                            </a>

                                        {{-- QUIZ --}}
                                        @else
                                            <a href="{{ route('siswa.quiz.show', $item->id) }}"
                                               class="
                                                   flex-1
                                                   @if($item->is_completed)
                                                       text-green-600
                                                   @else
                                                       text-gray-700
                                                   @endif
                                                   hover:underline
                                               ">
                                                📝 {{ $item->title }}
                                            </a>
                                        @endif

                                    @else
                                        <span class="flex-1 text-gray-400">
                                            {{ $item->type === 'lesson' ? '📘' : '📝' }}
                                            {{ $item->title }}
                                        </span>
                                    @endif

                                    @if($item->is_completed)
                                        <span class="text-green-600">✅</span>
                                    @elseif($item->is_locked)
                                        <span class="text-gray-400">🔒</span>
                                    @endif

                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endforeach

            </div>

        </aside>

    </div>
</div>

@endsection

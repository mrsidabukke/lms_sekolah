<aside
    x-show="sidebarOpen"
    x-transition
    class="w-80 border-l bg-gray-50 p-6 overflow-y-auto"
>

    <!-- PROGRESS -->
    <p class="text-sm text-gray-500 mb-2">
        Progress Kursus ({{ $progress }}%)
    </p>

    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
        <div
            class="bg-gray-900 h-2 rounded-full transition-all"
            style="width: {{ $progress }}%"
        ></div>
    </div>

    <!-- SECTION LIST -->
    <div class="space-y-6 text-sm">

        @foreach($sections as $section)
            <div x-data="{ open: true }" class="border-b pb-4">

                <!-- SECTION HEADER -->
                <button
                    type="button"
                    @click="open = !open"
                    class="w-full flex justify-between items-center
                           font-semibold text-gray-800 mb-2 hover:text-black"
                >
                    <span>{{ $section->title }}</span>
                    <span x-text="open ? '−' : '+'"></span>
                </button>

                <!-- ITEMS -->
                <ul
                    x-show="open"
                    x-transition
                    class="space-y-2 pl-3 border-l border-gray-200"
                >

                    @foreach($section->items as $item)
                        <li
                            class="flex items-center justify-between gap-2 p-2 rounded-lg
                                   {{ $item->type === 'task' ? 'bg-blue-50' : '' }}"
                        >

                            {{-- ===============================
                                ITEM TIDAK TERKUNCI
                            =============================== --}}
                            @if(!$item->is_locked)

                                {{-- 📘 LESSON --}}
                                @if($item->type === 'lesson')
                                    <a href="{{ route('siswa.modul.show', $item->id) }}"
                                       class="flex-1 hover:underline
                                           @if($item->id === $lesson->id)
                                               font-semibold text-black
                                           @elseif($item->is_completed)
                                               text-green-600
                                           @else
                                               text-gray-700
                                           @endif">
                                        📘 {{ $item->title }}
                                    </a>

                                {{-- 📝 QUIZ --}}
                                @elseif($item->type === 'quiz')
                                    <a href="{{ route('siswa.quiz.intro', $item->id) }}"
                                       class="flex-1 font-semibold hover:underline text-yellow-700">
                                        📝 {{ $item->title }}
                                    </a>

                                {{-- 📤 TASK (HALAMAN PENGUMPULAN) --}}
                                @elseif($item->type === 'task')
                                    <a href="{{ route('siswa.task.show', $item->id) }}"
                                       class="flex-1 font-semibold text-blue-700 hover:underline">
                                        📤 {{ $item->title }}
                                    </a>
                                @endif

                            {{-- ===============================
                                ITEM TERKUNCI
                            =============================== --}}
                            @else
                                <span class="flex-1 text-gray-400">
                                    @if($item->type === 'lesson') 📘
                                    @elseif($item->type === 'quiz') 📝
                                    @else 📤
                                    @endif
                                    {{ $item->title }}
                                </span>
                            @endif

                            {{-- STATUS ICON --}}
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

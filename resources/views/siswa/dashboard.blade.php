@extends('siswa.layout')

@section('content')

<div class="space-y-10">

    <!-- ================= HEADER ================= -->
    <div class="relative overflow-hidden rounded-2xl p-8 text-white
                bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900">

        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-2xl font-bold">
                    {{ $user->name }}
                </h1>
                <p class="text-sm text-gray-300">
                    NISN: {{ $user->nisn ?? '-' }}
                </p>
                <p class="text-sm text-gray-300">
                    Jurusan: {{ $departmentLabels[$user->department_id] ?? 'Umum' }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-300">Dashboard Siswa</p>
                <p id="datetime" class="text-sm font-semibold"></p>
            </div>

        </div>
    </div>

    <!-- ================= DAFTAR JURUSAN ================= -->
    <div class="bg-white rounded-2xl p-6 shadow border">

        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            Daftar Jurusan
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($departmentLabels as $deptId => $deptName)

                @php
                    $isMine = $user->department_id == $deptId;
                    $modules = $departments[$deptId] ?? collect();
                @endphp

                <div class="relative rounded-xl border p-6 transition
                    {{ $isMine
                        ? 'bg-white hover:shadow'
                        : 'bg-gray-100 opacity-60'
                    }}">

                    {{-- LOCK OVERLAY --}}
                    @unless($isMine)
                        <div class="absolute inset-0 flex items-center justify-center
                                    bg-white/70 rounded-xl">
                            <span class="text-gray-500 text-2xl">🔒</span>
                        </div>
                    @endunless

                    <h3 class="font-semibold text-gray-800 mb-2">
                        {{ $deptName }}
                    </h3>

                    <p class="text-sm text-gray-500 mb-4">
                        {{ $modules->count() }} Modul
                    </p>

                    {{-- MODULE LIST (HANYA JURUSAN SENDIRI) --}}
                    @if($isMine)
                        <ul class="space-y-2 text-sm">
                            @forelse($modules as $module)
                                <li>
                                    <a href="{{ route('siswa.modul.show', $module->lessons->first()->id ?? '#') }}"
                                       class="text-teal-600 hover:underline">
                                        ▶ {{ $module->title }}
                                    </a>
                                </li>
                            @empty
                                <li class="text-gray-400">
                                    Belum ada modul
                                </li>
                            @endforelse
                        </ul>
                    @endif

                </div>

            @endforeach

        </div>

    </div>

</div>

{{-- ================= CLOCK ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('datetime');

    const update = () => {
        const now = new Date();
        el.textContent = now.toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
        });
    };

    update();
    setInterval(update, 1000);
});
</script>

@endsection

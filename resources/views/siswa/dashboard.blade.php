@extends('siswa.layout')

@section('content')

<!-- HERO SECTION -->
<div class="bg-gradient-to-r from-gray-800 to-gray-700 rounded-2xl p-8 text-white mb-8">
    <h1 class="text-3xl font-bold">
        Selamat datang {{ auth()->user()->name }}!
    </h1>
    <p class="text-gray-200 mt-2">
        Semoga aktivitas belajarmu menyenangkan.
    </p>
</div>

<!-- STATUS KURSUS -->
<div class="bg-white rounded-2xl border border-gray-200 p-6 mb-8">
    <h2 class="text-lg font-semibold mb-4">
        Status Kursus
    </h2>

    <div class="flex items-center justify-between bg-gray-50 border rounded-xl p-4">
        <p class="text-gray-600">
            Kamu memiliki <strong>{{ $modules->count() }}</strong> kursus aktif.
        </p>

        <button class="px-4 py-2 text-sm bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
            Lihat Kursus
        </button>
    </div>
</div>

<!-- GRID SECTION -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- AKTIVITAS BELAJAR -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-lg">Aktivitas Belajar</h2>
            <span class="text-sm text-gray-500">Kursus</span>
        </div>

        <div class="space-y-4">
            @forelse($modules as $module)
                <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
                    <div>
                        <p class="text-sm text-gray-500">Sedang dipelajari</p>
                        <p class="font-medium text-gray-900">
                            {{ $module->title }}
                        </p>
                    </div>

                    <a href="{{ route('siswa.modul.show', $module) }}"
                       class="text-sm text-gray-700 hover:underline">
                        Lanjutkan →
                    </a>
                </div>
            @empty
                <p class="text-gray-500">Belum ada aktivitas belajar.</p>
            @endforelse
        </div>
    </div>

    <!-- AKTIVITAS LAIN -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="font-semibold text-lg mb-4">
            Aktivitas Lain
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="font-medium">Telusuri Event</p>
                <p class="text-sm text-gray-500 mt-1">
                    Kegiatan sekolah & jurusan
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <p class="font-medium">Telusuri Tantangan</p>
                <p class="text-sm text-gray-500 mt-1">
                    Latihan & evaluasi
                </p>
            </div>
        </div>
    </div>

</div>

@endsection

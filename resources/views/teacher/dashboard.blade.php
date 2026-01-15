@extends('layouts.teacher')

@section('title', 'Dashboard Guru')
@section('header_title', 'Beranda')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative group hover:border-indigo-300 transition">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Total Siswa</span>
                <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600">
                    <i class="ph ph-student text-lg"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</h3>
            <p class="text-xs text-green-600 font-semibold mt-2 flex items-center">
                <i class="ph ph-arrow-up mr-1"></i> Aktif di {{ $stats['kelas_aktif'] }} Kelas
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative group hover:border-orange-300 transition">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Tugas Perlu Dinilai</span>
                <div class="bg-orange-50 p-2 rounded-lg text-orange-600">
                    <i class="ph ph-clipboard-text text-lg"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['tugas_perlu_dinilai'] }}</h3>
            <p class="text-xs text-gray-400 font-medium mt-2">
                Dari {{ $stats['tugas_aktif'] }} Tugas aktif
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative group hover:border-green-300 transition">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Rata-rata Kelas</span>
                <div class="bg-green-50 p-2 rounded-lg text-green-600">
                    <i class="ph ph-trend-up text-lg"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['rata_rata_kelas'] }}</h3>
            <p class="text-xs text-green-600 font-semibold mt-2 flex items-center">
                <i class="ph ph-arrow-up mr-1"></i> +{{ $stats['kenaikan_rata_rata'] }}% dari bulan lalu
            </p>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Kelas & Mata Pelajaran Saya</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($my_subjects as $subject)
            <a href="{{ route('guru.mapel.detail', $subject->id) }}" class="block group">
                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md hover:border-indigo-300 transition h-full relative overflow-hidden">
                    
                    <div class="absolute right-0 top-0 opacity-5 transform translate-x-1/4 -translate-y-1/4 pointer-events-none">
                            <i class="ph {{ $subject->icon }} text-9xl text-indigo-900"></i>
                    </div>

                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="{{ $subject->color }} text-white w-12 h-12 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-200">
                            <i class="ph {{ $subject->icon }} text-2xl"></i>
                        </div>
                        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded">
                            {{ $subject->class }}
                        </span>
                    </div>

                    <div class="relative z-10">
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $subject->name }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $subject->students_count }} Siswa Terdaftar</p>
                    </div>

                    <div class="mt-4 relative z-10">
                        <div class="flex justify-between text-xs font-semibold text-gray-500 mb-1">
                            <span>Progress Materi</span>
                            <span>{{ $subject->progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $subject->progress }}%"></div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Jadwal Hari Ini</h3>
            
            <div class="space-y-4">
                @foreach($jadwal_hari_ini as $jadwal)
                <div class="flex items-center p-4 border border-gray-100 rounded-xl relative overflow-hidden hover:shadow-md transition bg-white">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $jadwal['color'] == 'blue' ? 'bg-indigo-500' : 'bg-pink-500' }}"></div>
                    
                    <div class="ml-3 flex-1">
                        <h4 class="font-bold text-gray-800 text-sm md:text-base">{{ $jadwal['mapel'] }}</h4>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">
                            {{ $jadwal['kelas'] }} • {{ $jadwal['ruang'] }}
                        </p>
                    </div>
                    <div class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-xs md:text-sm font-semibold whitespace-nowrap">
                        {{ $jadwal['jam'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Aktivitas Terbaru</h3>
            
            <div class="space-y-6">
                @foreach($aktivitas_terbaru as $activity)
                <div class="flex items-start group">
                    <div class="flex-shrink-0 relative">
                        @if(!$loop->last)
                        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-0.5 h-full bg-gray-100 -z-10"></div>
                        @endif

                        @if($activity['icon'] == 'upload')
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                                <i class="ph ph-upload-simple text-lg"></i>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 border border-green-100">
                                <i class="ph ph-check text-lg"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 pb-2">
                        <p class="text-sm text-gray-800">
                            <span class="font-bold">{{ $activity['user'] }}</span> {{ $activity['action'] }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="ph ph-clock mr-1"></i> {{ $activity['time'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection
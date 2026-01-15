@extends('layouts.teacher')

@section('title', 'Materi Pelajaran')
@section('header_title', 'Materi Pelajaran')

@section('content')

<div class="max-w-6xl mx-auto">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Kelola Bahan Ajar</h2>
            <p class="text-sm text-gray-500">Pilih kelas untuk melihat atau menambahkan materi pembelajaran.</p>
        </div>
        
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
        
        <a href="{{ route('guru.mapel.detail', $course->id) }}" class="block group h-full">
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-lg hover:border-indigo-300 transition h-full relative overflow-hidden flex flex-col justify-between">
                
                <div class="absolute -right-4 -top-4 opacity-5 transform rotate-12 group-hover:scale-110 transition duration-500">
                     <i class="ph {{ $course->icon }} text-9xl text-indigo-900"></i>
                </div>

                <div>
                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <div class="{{ $course->color }} text-white w-14 h-14 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100 group-hover:scale-110 transition duration-300">
                            <i class="ph {{ $course->icon }} text-3xl"></i>
                        </div>
                        
                        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1.5 rounded-full border border-gray-200 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                            {{ $course->class }}
                        </span>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition mb-1 line-clamp-2">
                            {{ $course->name }}
                        </h3>
                        <p class="text-sm text-gray-400">Terakhir update: {{ $course->last_update }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-50 relative z-10 flex items-center justify-between">
                    <div class="flex items-center text-sm font-semibold text-gray-600">
                        <i class="ph ph-files text-lg mr-2 text-gray-400"></i>
                        {{ $course->total_materi }} Materi
                    </div>
                    
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="ph ph-arrow-right font-bold"></i>
                    </div>
                </div>

            </div>
        </a>
        @endforeach
    </div>

    @if(count($courses) == 0)
    <div class="text-center py-20">
        <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="ph ph-chalkboard-teacher text-4xl text-gray-300"></i>
        </div>
        <h3 class="text-gray-800 font-bold text-lg">Belum ada kelas</h3>
        <p class="text-gray-500 text-sm">Anda belum ditugaskan di kelas manapun.</p>
    </div>
    @endif

</div>

@endsection
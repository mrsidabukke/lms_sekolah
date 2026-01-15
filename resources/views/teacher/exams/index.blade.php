@extends('layouts.teacher')

@section('title', 'Daftar Ujian')
@section('header_title', 'Bank Ujian & Kuis')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Daftar Ujian</h2>
            <p class="text-sm text-gray-500">Kelola ujian, kuis, dan ulangan harian</p>
        </div>
        <a href="{{ route('guru.ujian.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center shadow-lg shadow-indigo-200">
            <i class="ph ph-plus mr-2"></i> Buat Ujian Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($exams as $exam)
        <a href="{{ route('guru.ujian.show', $exam->id) }}" class="group block">
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:border-indigo-400 hover:shadow-md transition h-full relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="ph ph-files text-6xl text-indigo-900"></i>
                </div>
                
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                        <i class="ph ph-exam text-xl"></i>
                    </div>
                    <div>
                        <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                            {{ $exam->class_id ?? 'Kelas X' }}
                        </span>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition mb-2">{{ $exam->title }}</h3>
                <p class="text-sm text-gray-500 mb-4 line-clamp-1">{{ $exam->chapter ?? 'Topik Umum' }}</p>

                <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-50 pt-4">
                    <span class="flex items-center"><i class="ph ph-timer mr-1"></i> {{ $exam->duration_minutes }} Menit</span>
                    <span class="flex items-center"><i class="ph ph-list-numbers mr-1"></i> {{ $exam->questions_count ?? 0 }} Soal</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
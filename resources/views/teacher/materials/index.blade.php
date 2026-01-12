@extends('layouts.teacher')

@section('title', 'Materi Pelajaran')
@section('header_title', 'Materi Pelajaran')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500">Kelola bahan ajar untuk kelas Anda.</p>
        <a href="{{ route('guru.materi.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center shadow-lg shadow-indigo-200">
            <i class="ph ph-plus mr-2"></i> Tambah Materi
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 flex items-center animate-pulse">
        <i class="ph ph-check-circle text-xl mr-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 gap-4">
        @forelse($materials as $materi)
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between hover:border-indigo-200 transition group">
            <div class="flex items-center">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mr-5 {{ $materi->type == 'pdf' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500' }}">
                    <i class="ph {{ $materi->type == 'pdf' ? 'ph-file-pdf' : 'ph-play-circle' }}"></i>
                </div>
                
                <div>
                    <h3 class="font-bold text-gray-800 text-lg group-hover:text-indigo-600 transition">{{ $materi->title }}</h3>
                    <div class="flex items-center mt-1 space-x-3 text-sm text-gray-500">
                        <span class="flex items-center"><i class="ph ph-users mr-1"></i> {{ $materi->class }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center"><i class="ph ph-clock mr-1"></i> {{ $materi->date }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="p-2 bg-gray-50 rounded-lg text-gray-600 hover:bg-indigo-50 hover:text-indigo-600"><i class="ph ph-pencil-simple text-lg"></i></button>
                <button class="p-2 bg-gray-50 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600"><i class="ph ph-trash text-lg"></i></button>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
            <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ph ph-folder-notch-open text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-gray-800 font-bold text-lg">Belum ada materi</h3>
            <p class="text-gray-500 text-sm mb-4">Mulai upload materi pelajaran untuk siswa Anda</p>
        </div>
        @endforelse
    </div>

@endsection
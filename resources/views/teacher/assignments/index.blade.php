@extends('layouts.teacher')

@section('title', 'Daftar Tugas')
@section('header_title', 'Tugas & Ujian')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
             <h2 class="text-lg font-bold text-gray-800">Daftar Tugas Aktif</h2>
             <p class="text-sm text-gray-500">Pantau pengumpulan tugas siswa</p>
        </div>
        <a href="{{ route('guru.tugas.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center shadow-lg shadow-indigo-200">
            <i class="ph ph-plus mr-2"></i> Buat Tugas
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($assignments as $tugas)
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-indigo-300 transition">
            
            <div class="absolute top-4 right-4">
                @if($tugas->status == 'active')
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Aktif</span>
                @else
                    <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full">Selesai</span>
                @endif
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $tugas->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $tugas->subject }} • {{ $tugas->class }}</p>
            </div>

            <div class="mb-4">
                <div class="flex justify-between text-xs font-semibold mb-1">
                    <span class="text-gray-600">Dikumpulkan</span>
                    <span class="text-indigo-600">{{ $tugas->submitted_count }}/{{ $tugas->total_students }} Siswa</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($tugas->submitted_count / $tugas->total_students) * 100 }}%"></div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-50">
                <div class="text-xs text-gray-500 flex items-center">
                    <i class="ph ph-clock text-lg mr-1.5"></i> 
                    Deadline: {{ date('d M Y, H:i', strtotime($tugas->deadline)) }}
                </div>
                <a href="{{ route('guru.tugas.show', $tugas->id) }}" class="text-indigo-600 text-sm font-semibold hover:underline">
                    Lihat Submission &rarr;
                </a>
            </div>
        </div>
        @endforeach
    </div>

@endsection
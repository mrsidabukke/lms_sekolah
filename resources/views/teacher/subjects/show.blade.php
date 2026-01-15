@extends('layouts.teacher')

@section('title', 'Detail Mata Pelajaran')
@section('header_title', 'Detail Pembelajaran')

@section('content')

<div class="max-w-5xl mx-auto pb-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-2 transition text-sm">
                <i class="ph ph-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-gray-800">{{ $subjectInfo->name }}</h1>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 mt-1">
                {{ $subjectInfo->class }}
            </span>
        </div>
        
        <div class="flex space-x-6 bg-white px-6 py-3 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-center">
                <span class="block text-xl font-bold text-gray-800">{{ count($chapters) }}</span>
                <span class="text-xs text-gray-500 uppercase font-semibold">Bab</span>
            </div>
            <div class="w-px bg-gray-200"></div>
            <div class="text-center">
                <span class="block text-xl font-bold text-gray-800">30</span>
                <span class="text-xs text-gray-500 uppercase font-semibold">Siswa</span>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @foreach($chapters as $chapterName => $materials)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-lg flex items-center">
                    <i class="ph ph-bookmark-simple text-indigo-600 mr-2"></i>
                    {{ $chapterName }}
                </h3>
                
                <a href="{{ route('guru.materi.create', [
                    'class_id' => $subjectInfo->class_id,
                    'subject_id' => $subjectInfo->subject_id,
                    'chapter_name' => $chapterName
                ]) }}" 
                   class="text-sm font-semibold text-indigo-600 hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition border border-transparent hover:border-indigo-100 flex items-center">
                    <i class="ph ph-plus-circle mr-1.5"></i> Tambah Materi
                </a>
            </div>

            <div class="p-2">
                @if(count($materials) > 0)
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($materials as $materi)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition group border border-transparent hover:border-gray-100">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 {{ $materi->type == 'pdf' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                    <i class="ph {{ $materi->type == 'pdf' ? 'ph-file-pdf' : 'ph-play-circle' }} text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition">{{ $materi->title }}</h4>
                                    <p class="text-xs text-gray-400">Diposting: 07 Jan 2024</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition">
                                <button class="p-2 text-gray-400 hover:text-indigo-600" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                                <button class="p-2 text-gray-400 hover:text-red-600" title="Hapus"><i class="ph ph-trash"></i></button>
                                <a href="{{ $materi->link }}" class="p-2 text-gray-400 hover:text-green-600" title="Buka"><i class="ph ph-arrow-square-out"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-400 italic">Belum ada materi di bab ini.</p>
                        <a href="#" class="text-xs text-indigo-500 font-semibold hover:underline mt-1">Upload sekarang &rarr;</a>
                    </div>
                @endif
            </div>
        </div>
        @endforeach

        <button class="w-full py-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 font-semibold hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 transition flex items-center justify-center">
            <i class="ph ph-plus text-xl mr-2"></i> Buat Bab Baru
        </button>
    </div>

</div>
@endsection
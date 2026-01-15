@extends('layouts.teacher')

@section('title', 'Detail Tugas')
@section('header_title', 'Penilaian Tugas')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm">
    <i class="ph ph-check-circle text-xl mr-2"></i>
    {{ session('success') }}
</div>
@endif

<div class="flex flex-col lg:flex-row gap-8 relative">
    
    <div class="w-full lg:w-1/3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Latihan Soal Trigonometri</h2>
            <div class="flex items-center text-sm text-gray-500 mb-6">
                <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold mr-2">Kelas X-A</span>
                <span><i class="ph ph-calendar mr-1"></i> 10 Jan 2024</span>
            </div>
            
            <div class="prose prose-sm text-gray-600 mb-6">
                <p>Kerjakan soal halaman 50 nomor 1-10. Upload jawaban dalam format PDF.</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                <div class="flex items-center text-sm font-semibold text-gray-700">
                    <i class="ph ph-file-pdf text-xl text-red-500 mr-2"></i>
                    Soal_Latihan.pdf
                </div>
                <button class="text-xs text-indigo-600 hover:underline">Download</button>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-2/3">
        
        <form action="{{ route('guru.tugas.bulk_grade', request()->route('id')) }}" method="POST"> 
            @csrf
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-800">Lembar Penilaian</h3>
                        <span class="text-sm text-gray-500">Input nilai langsung di tabel ini</span>
                    </div>
                    
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition flex items-center shadow-md shadow-indigo-200">
                        <i class="ph ph-floppy-disk mr-2 text-lg"></i> Simpan Perubahan
                    </button>
                </div>
    
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr class="text-xs uppercase text-gray-500 font-bold border-b border-gray-200">
                                <th class="px-6 py-4 w-1/4">Siswa</th>
                                <th class="px-6 py-4 w-1/6">Status</th>
                                <th class="px-6 py-4 w-1/6 text-center">Nilai (0-100)</th>
                                <th class="px-6 py-4 w-1/3">Feedback / Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @foreach($submissions as $sub)
                            
                            <tr class="transition hover:bg-gray-50 {{ ($sub->status == 'submitted' && $sub->score == null) ? 'bg-yellow-50/50' : 'bg-white' }}">
                                
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $sub->name }}</div>
                                    <div class="text-xs text-gray-400 mt-1 flex items-center">
                                        @if($sub->submitted_at)
                                            <i class="ph ph-clock mr-1"></i> {{ date('d M H:i', strtotime($sub->submitted_at)) }}
                                        @else
                                            <span class="text-red-400">Belum mengumpulkan</span>
                                        @endif
                                    </div>
                                    
                                    @if(isset($sub->file_path))
                                        <a href="#" class="text-xs text-indigo-600 hover:underline mt-1 block">
                                            <i class="ph ph-file-text"></i> Lihat Jawaban
                                        </a>
                                    @endif
                                </td>
    
                                <td class="px-6 py-4">
                                    @if($sub->status == 'graded')
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700">
                                            <i class="ph ph-check-circle mr-1"></i> Selesai
                                        </span>
                                    @elseif($sub->status == 'submitted')
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-700 animate-pulse">
                                            Perlu Dinilai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-500">
                                            Pending
                                        </span>
                                    @endif
                                </td>
    
                                <td class="px-6 py-4 text-center">
                                    <input type="number" 
                                           name="submissions[{{ $sub->student_id ?? $sub->id }}][score]" 
                                           value="{{ $sub->score }}" 
                                           min="0" max="100" 
                                           class="w-20 text-center font-bold text-gray-800 border border-gray-300 rounded-lg py-2 px-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                           placeholder="-">
                                </td>
    
                                <td class="px-6 py-4">
                                    <input type="text" 
                                           name="submissions[{{ $sub->student_id ?? $sub->id }}][feedback]"
                                           value="{{ $sub->feedback ?? '' }}" 
                                           class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition placeholder-gray-400"
                                           placeholder="Tulis komentar...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex justify-between items-center">
                    <span class="flex items-center"><i class="ph ph-info mr-1"></i> Tekan tombol <b>TAB</b> di keyboard untuk pindah kolom dengan cepat.</span>
                    <span>Total: {{ count($submissions) }} Siswa</span>
                </div>
            </div>
        </form> 
        </div>
</div>

@endsection
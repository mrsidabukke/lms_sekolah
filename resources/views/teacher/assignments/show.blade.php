@extends('layouts.teacher')

@section('title', 'Detail Tugas')
@section('header_title', 'Penilaian Tugas')

@section('content')

<div class="flex flex-col lg:flex-row gap-8">
    
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

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                    <i class="ph ph-file-pdf text-xl text-red-500 mr-2"></i>
                    Soal_Latihan.pdf
                </div>
                <button class="text-xs text-indigo-600 hover:underline">Download Lampiran</button>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-2/3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Submission Siswa</h3>
                <span class="text-sm text-gray-500">Total: 30 Siswa</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-sm text-gray-500 border-b border-gray-100">
                            <th class="px-6 py-3 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-3 font-semibold">Waktu Mengumpulkan</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Nilai</th>
                            <th class="px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($submissions as $sub)
                        <tr class="hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $sub->name }}</td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $sub->submitted_at ? $sub->submitted_at : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($sub->status == 'graded')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Sudah Dinilai
                                    </span>
                                @elseif($sub->status == 'submitted')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Menunggu Dinilai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Belum Mengumpulkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $sub->score ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($sub->status != 'pending')
                                <button class="text-indigo-600 hover:text-indigo-800 font-medium text-xs border border-indigo-200 px-3 py-1.5 rounded hover:bg-indigo-50 transition">
                                    <i class="ph ph-pencil-simple mr-1"></i> Nilai
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
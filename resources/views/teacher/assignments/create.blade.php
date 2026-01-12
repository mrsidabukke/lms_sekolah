@extends('layouts.teacher')

@section('title', 'Buat Tugas Baru')
@section('header_title', 'Buat Tugas')

@section('content')

<div class="max-w-4xl mx-auto">
    <a href="{{ route('guru.tugas.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition">
        <i class="ph ph-arrow-left mr-2"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Tugas</label>
                    <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Misal: Latihan Soal Bab 1">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Instruksi / Soal</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Tuliskan detail soal atau instruksi pengerjaan..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kelas</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white outline-none">
                            <option>Kelas X-A</option>
                            <option>Kelas XI-B</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Batas Waktu (Deadline)</label>
                        <input type="datetime-local" name="deadline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-gray-600">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Lampiran File (Opsional)</label>
                    <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition"/>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium shadow-lg shadow-indigo-200 transition">
                    Terbitkan Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
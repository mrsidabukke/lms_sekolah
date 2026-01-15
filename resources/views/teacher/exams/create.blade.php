@extends('layouts.teacher')
@section('title', 'Buat Ujian')
@section('header_title', 'Buat Ujian Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('guru.ujian.store') }}" method="POST">
            @csrf
            <h2 class="text-lg font-bold text-gray-800 mb-6 border-b border-gray-100 pb-2">Informasi Dasar</h2>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Ujian</label>
                    <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: UTS Matematika Semester 1" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran</label>
                        <select name="subject_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white outline-none">
                            <option value="1">Matematika Wajib</option>
                            <option value="2">Fisika</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kelas</label>
                        <select name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white outline-none">
                            <option value="1">Kelas X-A</option>
                            <option value="2">Kelas XI-B</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Durasi Pengerjaan (Menit)</label>
                        <div class="relative">
                            <input type="number" name="duration_minutes" value="60" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                            <span class="absolute right-4 top-2 text-sm text-gray-500">Menit</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Batas Akses</label>
                        <input type="datetime-local" name="deadline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Bab / Topik (Opsional)</label>
                    <input type="text" name="chapter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Bab Trigonometri">
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Simpan & Lanjut ke Soal &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
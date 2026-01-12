@extends('layouts.teacher')

@section('title', 'Upload Materi')
@section('header_title', 'Upload Materi Baru')

@section('content')

<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('guru.materi.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition">
        <i class="ph ph-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-800">Detail Materi</h2>
            <p class="text-sm text-gray-500">Lengkapi informasi materi pelajaran di bawah ini</p>
        </div>

        <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Materi</label>
                    <input type="text" name="title" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="Contoh: Modul Bab 1 - Aljabar">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran</label>
                        <select name="subject_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option>Matematika Wajib</option>
                            <option>Matematika Peminatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kelas Tujuan</label>
                        <select name="class_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option>Kelas X-A</option>
                            <option>Kelas XI-B</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Tipe Materi</label>
                    <div class="flex space-x-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="pdf" checked class="peer sr-only" onclick="toggleUpload('pdf')">
                            <div class="px-5 py-3 border border-gray-200 rounded-xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 flex items-center transition">
                                <i class="ph ph-file-pdf text-xl mr-2"></i> Dokumen
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="video" class="peer sr-only" onclick="toggleUpload('video')">
                            <div class="px-5 py-3 border border-gray-200 rounded-xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 flex items-center transition">
                                <i class="ph ph-video text-xl mr-2"></i> Video Link
                            </div>
                        </label>
                    </div>
                </div>

                <div id="file-input-area" class="border-2 border-dashed border-gray-300 rounded-xl p-10 text-center hover:bg-gray-50 transition cursor-pointer relative group">
                    <input type="file" name="file_upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="ph ph-cloud-arrow-up text-3xl"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-800">Klik untuk upload file materi</p>
                    <p class="text-xs text-gray-400 mt-1">PDF, PPT, DOCX (Max. 10MB)</p>
                </div>

                <div id="video-input-area" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">URL Video</label>
                    <input type="url" name="video_url" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="https://youtube.com/...">
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium shadow-lg shadow-indigo-200 transition">
                    Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleUpload(type) {
        const fileArea = document.getElementById('file-input-area');
        const videoArea = document.getElementById('video-input-area');
        if (type === 'pdf') {
            fileArea.classList.remove('hidden');
            videoArea.classList.add('hidden');
        } else {
            fileArea.classList.add('hidden');
            videoArea.classList.remove('hidden');
        }
    }
</script>

@endsection
@extends('layouts.teacher')

@section('title', 'Upload Materi')
@section('header_title', 'Upload Materi Baru')

@section('content')

<div class="max-w-4xl mx-auto pb-10">
    
    <a href="{{ route('guru.materi.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition">
        <i class="ph ph-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-800">Detail Materi</h2>
            <p class="text-sm text-gray-500">Isi hierarki kelas dan link materi pembelajaran</p>
        </div>

        <form action="{{ route('guru.materi.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">

                <div class="bg-indigo-50/50 p-6 rounded-xl border border-indigo-100">
                    <h3 class="text-sm font-bold text-indigo-900 mb-4 flex items-center">
                        <i class="ph ph-tree-structure mr-2"></i> Target Pembelajaran
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-2 uppercase">Tingkat</label>
                            <select name="grade_level" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="" disabled {{ !request('grade_level') ? 'selected' : '' }}>Pilih Tingkat</option>
                                <option value="X" {{ request('grade_level') == 'X' ? 'selected' : '' }}>Kelas X</option>
                                <option value="XI" {{ request('grade_level') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                                <option value="XII" {{ request('grade_level') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-2 uppercase">Jurusan</label>
                            <select name="major" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="" disabled {{ !request('major') ? 'selected' : '' }}>Pilih Jurusan</option>
                                <option value="RPL" {{ request('major') == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                <option value="TKJ" {{ request('major') == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                                <option value="AKL" {{ request('major') == 'AKL' ? 'selected' : '' }}>Akuntansi</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-2 uppercase">Mata Pelajaran</label>
                            <select name="subject_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="" disabled {{ !request('subject_id') ? 'selected' : '' }}>Pilih Mapel</option>
                                <option value="1" {{ request('subject_id') == '1' ? 'selected' : '' }}>Matematika Wajib</option>
                                <option value="2" {{ request('subject_id') == '2' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                <option value="3" {{ request('subject_id') == '3' ? 'selected' : '' }}>Pemrograman Dasar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Bab / Topik</label>
                        <div class="relative">
                            <input type="text" list="chapters_list" name="chapter" value="{{ request('chapter_name') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Ketik nama Bab baru...">
                            <datalist id="chapters_list">
                                <option value="Bab 1: Eksponen & Logaritma">
                                <option value="Bab 2: Persamaan Linear">
                                <option value="Bab 3: Matriks">
                            </datalist>
                            <p class="text-xs text-gray-400 mt-1">*Pilih dari list atau ketik judul bab baru</p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Materi</label>
                        <input type="text" name="title" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Pembahasan Soal Latihan 1.1">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Tipe & Sumber Materi</label>
                    
                    <div class="flex space-x-6 mb-4 border-b border-gray-200">
                        <label class="cursor-pointer pb-2 border-b-2 border-indigo-600 text-indigo-600 font-medium transition" id="tab-pdf">
                            <input type="radio" name="type" value="pdf" checked class="hidden" onclick="switchType('pdf')">
                            <i class="ph ph-file-pdf mr-1"></i> Dokumen (PDF/Drive)
                        </label>
                        <label class="cursor-pointer pb-2 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium transition" id="tab-video">
                            <input type="radio" name="type" value="video" class="hidden" onclick="switchType('video')">
                            <i class="ph ph-youtube-logo mr-1"></i> Video Pembelajaran
                        </label>
                    </div>

                    <div id="input-pdf" class="animate-fade-in">
                        <div class="flex items-center space-x-2 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                            <i class="ph ph-google-drive-logo text-xl text-gray-500"></i>
                            <input type="url" name="link_url_pdf" class="w-full bg-transparent outline-none text-sm text-gray-700 placeholder-gray-400" placeholder="Paste link Google Drive PDF di sini (Pastikan akses 'Anyone with the link')...">
                        </div>
                        <p class="text-xs text-gray-400 mt-1 ml-1">Support: Google Drive Link, Dropbox, atau Direct URL PDF.</p>
                    </div>

                    <div id="input-video" class="hidden animate-fade-in">
                        <div class="flex items-center space-x-2 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                            <i class="ph ph-link text-xl text-gray-500"></i>
                            <input type="url" name="link_url_video" class="w-full bg-transparent outline-none text-sm text-gray-700 placeholder-gray-400" placeholder="Paste link YouTube atau Video Drive di sini...">
                        </div>
                        <p class="text-xs text-gray-400 mt-1 ml-1">Support: YouTube URL, Google Drive Video Link.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catatan</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none placeholder-gray-400" placeholder="Berikan catatan untuk siswa..."></textarea>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium shadow-lg shadow-indigo-200 transition">
                    <i class="ph ph-paper-plane-right mr-2"></i> Publikasikan 
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchType(type) {
        const inputPdf = document.getElementById('input-pdf');
        const inputVideo = document.getElementById('input-video');
        const tabPdf = document.getElementById('tab-pdf');
        const tabVideo = document.getElementById('tab-video');
        
        // Input Logic (Memberikan nama attribute 'link_url' ke input yang aktif)
        // Agar controller hanya menerima satu 'link_url'
        const fieldPdf = inputPdf.querySelector('input');
        const fieldVideo = inputVideo.querySelector('input');

        if (type === 'pdf') {
            inputPdf.classList.remove('hidden');
            inputVideo.classList.add('hidden');
            
            // Styling Tab
            tabPdf.classList.add('border-indigo-600', 'text-indigo-600');
            tabPdf.classList.remove('border-transparent', 'text-gray-500');
            tabVideo.classList.remove('border-indigo-600', 'text-indigo-600');
            tabVideo.classList.add('border-transparent', 'text-gray-500');

            // Name Attribute Logic
            fieldPdf.setAttribute('name', 'link_url');
            fieldVideo.setAttribute('name', 'link_url_inactive'); // Matikan input video

        } else {
            inputPdf.classList.add('hidden');
            inputVideo.classList.remove('hidden');

            // Styling Tab
            tabVideo.classList.add('border-indigo-600', 'text-indigo-600');
            tabVideo.classList.remove('border-transparent', 'text-gray-500');
            tabPdf.classList.remove('border-indigo-600', 'text-indigo-600');
            tabPdf.classList.add('border-transparent', 'text-gray-500');

             // Name Attribute Logic
             fieldVideo.setAttribute('name', 'link_url');
             fieldPdf.setAttribute('name', 'link_url_inactive'); // Matikan input pdf
        }
    }

    // Initialize (Set PDF as default name)
    document.addEventListener("DOMContentLoaded", function() {
        switchType('pdf'); 
    });
</script>

@endsection
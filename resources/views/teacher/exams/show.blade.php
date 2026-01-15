@extends('layouts.teacher')
@section('title', 'Kelola Soal')
@section('header_title', 'Penyusunan Soal')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center shadow-sm animate-fade-in-down">
    <i class="ph ph-check-circle text-xl mr-2"></i>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-8">
    
    <div class="w-full lg:w-2/5">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="ph ph-plus-circle text-indigo-600 mr-2 text-xl"></i> Input Soal
                </h3>
                <button onclick="document.getElementById('importModal').classList.remove('hidden')" 
                        class="text-xs bg-green-50 text-green-700 px-3 py-1.5 rounded-lg font-bold hover:bg-green-100 transition flex items-center border border-green-200">
                    <i class="ph ph-microsoft-excel-logo mr-1.5 text-lg"></i> Import Excel
                </button>
            </div>
            
            <form action="{{ route('guru.ujian.store_question', $exam->id) }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan</label>
                    <textarea name="question" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Tulis pertanyaan soal di sini..." required></textarea>
                </div>

                <div class="space-y-4 mb-6">
                    <label class="block text-sm font-bold text-gray-700">Opsi Jawaban</label>
                    
                    @foreach(['a','b','c','d'] as $opt)
                    <div class="flex items-center group">
                        <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center bg-gray-100 text-gray-500 rounded-full font-bold mr-2 uppercase group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">{{ $opt }}</div>
                        <input type="text" name="option_{{ $opt }}" class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Jawaban {{ strtoupper($opt) }}" required>
                    </div>
                    @endforeach
                </div>

                <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 mb-6">
                    <label class="block text-sm font-bold text-indigo-900 mb-2">Kunci Jawaban Benar</label>
                    <div class="relative">
                        <select name="correct_option" class="w-full px-4 py-2.5 border border-indigo-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer appearance-none" required>
                            <option value="" disabled selected>Pilih Kunci Jawaban...</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                        <div class="absolute right-3 top-3 pointer-events-none text-indigo-500">
                            <i class="ph ph-caret-down font-bold"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex justify-center items-center">
                    <i class="ph ph-check mr-2 font-bold"></i> Simpan Soal
                </button>
            </form>
        </div>
    </div>

    <div class="w-full lg:w-3/5">
        
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl p-6 text-white shadow-lg shadow-indigo-200 mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">{{ $exam->title }}</h2>
                <div class="flex items-center text-indigo-100 text-sm mt-1 space-x-4">
                    <span class="flex items-center bg-white/10 px-2 py-1 rounded"><i class="ph ph-clock mr-1.5"></i> {{ $exam->duration_minutes }} Menit</span>
                    <span class="flex items-center bg-white/10 px-2 py-1 rounded"><i class="ph ph-calendar mr-1.5"></i> {{ date('d M Y', strtotime($exam->deadline)) }}</span>
                </div>
            </div>
            <div class="text-center bg-white text-indigo-700 px-4 py-2 rounded-lg shadow-sm">
                <span class="block text-2xl font-bold">{{ $questions->count() }}</span>
                <span class="text-[10px] font-bold uppercase tracking-wider">Soal</span>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($questions as $index => $q)
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition group relative overflow-hidden">
                <div class="absolute top-0 left-0 bg-gray-100 text-gray-500 px-3 py-1 rounded-br-xl text-xs font-bold">
                    No. {{ $index + 1 }}
                </div>

                <div class="mt-4">
                    <p class="text-gray-800 font-medium text-lg mb-4 leading-relaxed">{{ $q->question }}</p>
                    
                    <div class="grid grid-cols-1 gap-2">
                        @foreach(['a','b','c','d'] as $opt)
                        @php 
                            $colName = 'option_'.$opt; 
                            $isCorrect = strtolower($q->correct_option) == $opt;
                        @endphp
                        <div class="flex items-center p-2 rounded-lg border {{ $isCorrect ? 'bg-green-50 border-green-200' : 'border-transparent' }}">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mr-3 {{ $isCorrect ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-500' }}">
                                {{ strtoupper($opt) }}
                            </div>
                            <span class="text-sm {{ $isCorrect ? 'text-green-800 font-semibold' : 'text-gray-600' }}">
                                {{ $q->$colName }}
                            </span>
                            @if($isCorrect)
                                <i class="ph ph-check-circle text-green-600 ml-auto"></i>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                    <form action="{{ route('guru.ujian.destroy_question', $q->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-50 text-red-500 p-2 rounded-lg hover:bg-red-600 hover:text-white transition" title="Hapus Soal">
                            <i class="ph ph-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl border border-dashed border-gray-300 text-center">
                <div class="bg-indigo-50 p-4 rounded-full mb-3">
                    <i class="ph ph-pencil-slash text-3xl text-indigo-400"></i>
                </div>
                <h3 class="text-gray-800 font-bold">Belum ada soal</h3>
                <p class="text-gray-500 text-sm mt-1 max-w-xs">Silakan input pertanyaan secara manual atau gunakan fitur Import Excel.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div id="importModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity backdrop-blur-sm" onclick="document.getElementById('importModal').classList.add('hidden')"></div>

    <div class="flex items-center justify-center min-h-screen p-4 pointer-events-none">
        <div class="bg-white rounded-2xl shadow-2xl transform transition-all sm:max-w-md w-full overflow-hidden pointer-events-auto">
            
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="ph ph-microsoft-excel-logo text-green-600 mr-2 text-xl"></i> Import Soal
                </h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('guru.ujian.import', $exam->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="mb-5">
                    <div class="flex items-center mb-2">
                        <span class="bg-indigo-100 text-indigo-700 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mr-2">1</span>
                        <p class="text-sm font-bold text-gray-700">Download Template</p>
                    </div>
                    <p class="text-xs text-gray-500 ml-8 mb-2">Gunakan template ini agar format sesuai sistem.</p>
                    <a href="{{ route('guru.ujian.template') }}" class="ml-8 inline-flex items-center text-xs bg-white border border-gray-300 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition font-semibold">
                        <i class="ph ph-download-simple mr-2 text-lg"></i> template_soal.xlsx
                    </a>
                </div>

                <hr class="border-gray-100 my-4">

                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <span class="bg-indigo-100 text-indigo-700 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mr-2">2</span>
                        <p class="text-sm font-bold text-gray-700">Upload File Excel</p>
                    </div>
                    <div class="ml-8">
                        <input type="file" name="file_excel" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p class="text-[10px] text-gray-400 mt-2">*Mendukung format .xlsx dan .csv</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-200 flex justify-center items-center">
                    <i class="ph ph-upload-simple mr-2 font-bold"></i> Upload & Proses Soal
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
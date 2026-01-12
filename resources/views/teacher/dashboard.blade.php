<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuruLink - Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <div class="bg-indigo-600 text-white p-1.5 rounded-lg mr-2">
                    <i class="ph ph-graduation-cap text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">GuruLink</span>
            </div>

            <nav class="mt-6 px-4 space-y-1">
                <a href="#" class="flex items-center px-4 py-3 text-indigo-600 bg-indigo-50 rounded-lg font-medium">
                    <i class="ph ph-house text-xl mr-3"></i>
                    Beranda
                </a>
                <a href="{{ route('guru.materi.index') }}" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-lg font-medium transition">
                    <i class="ph ph-book-open text-xl mr-3"></i>
                    Materi Pelajaran
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-lg font-medium transition">
                    <i class="ph ph-clipboard-text text-xl mr-3"></i>
                    Tugas & Ujian
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-lg font-medium transition">
                    <i class="ph ph-star text-xl mr-3"></i>
                    Penilaian
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-lg font-medium transition">
                    <i class="ph ph-users text-xl mr-3"></i>
                    Data Siswa
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                    PB
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-800">Budi Santoso, S.Pd</p>
                    <p class="text-xs text-gray-500">Guru Matematika</p>
                </div>
            </div>
            <button class="w-full border border-gray-300 rounded-lg py-2 text-sm text-gray-600 flex items-center justify-center hover:bg-gray-50">
                <i class="ph ph-sign-out mr-2"></i> Keluar
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <h1 class="text-2xl font-bold text-gray-800">Beranda</h1>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="ph ph-bell text-xl text-gray-500"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
                <div class="relative">
                    <i class="ph ph-magnifying-glass absolute left-3 top-2.5 text-gray-400"></i>
                    <input type="text" placeholder="Cari materi atau siswa..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
                </div>
            </div>
        </header>

        <div class="p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-sm">Total Siswa</span>
                        <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                            <i class="ph ph-student text-lg"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</h3>
                    <p class="text-xs text-green-500 font-medium mt-1">↑ Aktif di {{ $stats['kelas_aktif'] }} Kelas</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-sm">Tugas Perlu Dinilai</span>
                        <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                            <i class="ph ph-clipboard-text text-lg"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['tugas_perlu_dinilai'] }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Dari {{ $stats['tugas_aktif'] }} Tugas aktif</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-sm">Rata-rata Kelas</span>
                        <div class="bg-green-100 p-2 rounded-lg text-green-600">
                            <i class="ph ph-trend-up text-lg"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['rata_rata_kelas'] }}</h3>
                    <p class="text-xs text-green-500 font-medium mt-1">↑ +{{ $stats['kenaikan_rata_rata'] }}% dari bulan lalu</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Jadwal Hari Ini</h3>
                    
                    <div class="space-y-4">
                        @foreach($jadwal_hari_ini as $jadwal)
                        <div class="flex items-center p-4 border border-gray-100 rounded-xl relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $jadwal['color'] == 'blue' ? 'bg-indigo-500' : 'bg-pink-500' }}"></div>
                            
                            <div class="ml-3 flex-1">
                                <h4 class="font-bold text-gray-800">{{ $jadwal['mapel'] }}</h4>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $jadwal['kelas'] }} • {{ $jadwal['ruang'] }}
                                </p>
                            </div>
                            <div class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-sm font-semibold">
                                {{ $jadwal['jam'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Aktivitas Terbaru</h3>
                    
                    <div class="space-y-6">
                        @foreach($aktivitas_terbaru as $activity)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($activity['icon'] == 'upload')
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="ph ph-upload-simple text-lg"></i>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <i class="ph ph-check text-lg"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-800">
                                    <span class="font-bold">{{ $activity['user'] }}</span> {{ $activity['action'] }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

</body>
</html>
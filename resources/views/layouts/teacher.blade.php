<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Sekolah - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex z-10">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <div class="bg-indigo-600 text-white p-1.5 rounded-lg mr-2">
                    <i class="ph ph-graduation-cap text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">LMS Sekolah</span>
            </div>

            <nav class="mt-6 px-4 space-y-1">
                
                <a href="{{ route('guru.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg font-medium transition
                   {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="ph ph-house text-xl mr-3"></i>
                    Beranda
                </a>

                <a href="{{ route('guru.materi.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg font-medium transition
                   {{ request()->is('guru/materi*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="ph ph-book-open text-xl mr-3"></i>
                    Materi Pelajaran
                </a>

                <a href="{{ route('guru.tugas.index') }}" 
                    class="flex items-center px-4 py-3 rounded-lg font-medium transition
                    {{ request()->is('guru/tugas*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="ph ph-clipboard-text text-xl mr-3"></i>
                        Tugas
                </a>

                <a href="{{ route('guru.ujian.index') }}" 
                    class="flex items-center px-4 py-3 rounded-lg font-medium transition
                    {{ request()->is('guru/ujian*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="ph ph-exam text-xl mr-3"></i>
                        Ujian & Kuis
                </a>

                <a href="{{ route('guru.siswa.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg font-medium transition
                   {{ request()->is('guru/siswa*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="ph ph-users text-xl mr-3"></i>
                    Data Siswa
                </a>

            </nav>
        </div>

        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">BS</div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-800">Budi Santoso</p>
                    <p class="text-xs text-gray-500">Guru Matematika</p>
                </div>
            </div>
            <button class="w-full border border-gray-300 rounded-lg py-2 text-sm text-gray-600 hover:bg-gray-50 transition">
                <i class="ph ph-sign-out mr-2"></i> Keluar
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
            <h1 class="text-2xl font-bold text-gray-800">@yield('header_title', 'Dashboard')</h1>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="ph ph-bell text-xl text-gray-500"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
                <div class="relative hidden sm:block">
                    <i class="ph ph-magnifying-glass absolute left-3 top-2.5 text-gray-400"></i>
                    <input type="text" placeholder="Cari..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>

    </main>
</div>

</body>
</html>
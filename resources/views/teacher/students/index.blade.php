@extends('layouts.teacher')

@section('title', 'Data Siswa')
@section('header_title', 'Data Siswa')

@section('content')

<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center space-x-4">
        <div class="relative">
            <select class="appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2.5 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-medium cursor-pointer">
                <option value="">Semua Kelas</option>
                <option value="X-A">Kelas X-A</option>
                <option value="XI-B">Kelas XI-B</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <i class="ph ph-caret-down"></i>
            </div>
        </div>
        
        <div class="relative hidden sm:block">
            <select class="appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2.5 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-medium cursor-pointer">
                <option value="">Status: Semua</option>
                <option value="active">Aktif</option>
                <option value="inactive">Non-Aktif</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <i class="ph ph-caret-down"></i>
            </div>
        </div>
    </div>

    <div class="relative w-full md:w-64">
        <i class="ph ph-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
        <input type="text" placeholder="Cari nama atau NISN..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr class="text-xs uppercase text-gray-500 font-bold border-b border-gray-200 tracking-wider">
                    <th class="px-6 py-4">Siswa</th>
                    <th class="px-6 py-4">NISN / Kelas</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4 text-center">Rata-rata Nilai</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach($students as $siswa)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm border-2 border-white shadow-sm">
                                    {{ substr($siswa->name, 0, 2) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="font-bold text-gray-900">{{ $siswa->name }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($siswa->gender == 'L') Laki-laki @else Perempuan @endif
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-gray-900 font-medium">{{ $siswa->nisn }}</div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                            {{ $siswa->class }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col space-y-1">
                            <div class="flex items-center text-gray-500 text-xs">
                                <i class="ph ph-envelope-simple mr-2"></i> {{ $siswa->email }}
                            </div>
                            <div class="flex items-center text-gray-500 text-xs">
                                <i class="ph ph-whatsapp-logo mr-2"></i> {{ $siswa->phone }}
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="font-bold {{ $siswa->avg_score >= 90 ? 'text-green-600' : ($siswa->avg_score >= 75 ? 'text-indigo-600' : 'text-red-500') }}">
                            {{ $siswa->avg_score }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($siswa->status == 'active')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                Non-Aktif
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-gray-400 hover:text-indigo-600 transition mx-1" title="Lihat Detail">
                            <i class="ph ph-eye text-xl"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
        <span class="text-sm text-gray-500">Menampilkan 1-3 dari 3 siswa</span>
        <div class="flex space-x-2">
            <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-500 text-sm hover:bg-gray-100 disabled:opacity-50" disabled>Previous</button>
            <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-500 text-sm hover:bg-gray-100 disabled:opacity-50" disabled>Next</button>
        </div>
    </div>
</div>

@endsection
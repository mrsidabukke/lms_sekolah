@extends('siswa.layout')

@section('content')

<div class="space-y-12">

    <!-- ================= HEADER ================= -->
    <div class="relative overflow-hidden rounded-2xl p-8 text-white
                bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900">

        <div class="flex justify-between items-center">

            <div class="flex items-center gap-6">

                <!-- FOTO -->
                <form method="POST"
                      action="{{ route('siswa.profile.photo') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <label class="cursor-pointer">
                        <img
                            src="{{ $user->photo
                                    ? asset('storage/'.$user->photo)
                                    : 'https://ui-avatars.com/api/?name='.$user->name }}"
                            class="w-20 h-20 rounded-full object-cover border-2 border-white"
                        >
                        <input type="file" name="photo" class="hidden" onchange="this.form.submit()">
                    </label>
                </form>

                <div>
                    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                    <p class="text-sm text-gray-300">NISN: {{ $user->nisn ?? '-' }}</p>
                    <p class="text-sm text-gray-300">
        Kelas: {{ $user->class_level ?? '-' }}
    </p>
                    <p class="text-sm text-gray-300">
                        Jurusan: {{ $user->department->name ?? '-' }}
                    </p>
                </div>

            </div>

            <div class="text-right">
                <p class="text-sm text-gray-300">Dashboard Siswa</p>
                <p id="datetime" class="text-sm font-semibold"></p>
            </div>

        </div>
    </div>

    <!-- ================= DAFTAR JURUSAN ================= -->
    <div class="bg-white rounded-2xl p-6 shadow border">
        <h2 class="text-lg font-semibold mb-6">Daftar Jurusan</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($departments as $department)

                @php $isMine = $department->id === $user->department_id; @endphp

                <div class="relative rounded-xl border p-6
                    {{ $isMine ? 'bg-white' : 'bg-gray-100 opacity-60' }}">

                    @unless($isMine)
                        <div class="absolute inset-0 flex items-center justify-center bg-white/70 rounded-xl">
                            <span class="text-2xl">🔒</span>
                        </div>
                    @endunless

                    <h3 class="font-semibold">{{ $department->name }}</h3>
                    <p class="text-sm text-gray-500">
                        {{ $department->modules_count }} Modul
                    </p>
                </div>

            @endforeach
        </div>
    </div>

    <!-- ================= KURSUS SAYA ================= -->
    <div class="bg-white rounded-2xl p-6 shadow border">
        <h2 class="text-lg font-semibold mb-6">Kursus Saya</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($myModules as $module)
                <div class="border rounded-xl p-6 hover:shadow transition">
                    <h3 class="font-semibold text-gray-800 mb-2">
                        {{ $module->title }}
                    </h3>

                    <p class="text-sm text-gray-500 mb-4">
                        {{ $module->description }}
                    </p>

                    <a href="{{ route('siswa.modul.show', $module->lessons->first()->id) }}"
                       class="text-teal-600 font-semibold hover:underline">
                        ▶ Mulai Belajar
                    </a>
                </div>
            @empty
                <p class="text-gray-400">Belum ada kursus</p>
            @endforelse

        </div>
    </div>

</div>

{{-- ================= CLOCK ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('datetime');
    const update = () => {
        el.textContent = new Date().toLocaleString('id-ID', {
            weekday:'long', year:'numeric', month:'long',
            day:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit'
        });
    };
    update(); setInterval(update, 1000);
});
</script>

@endsection

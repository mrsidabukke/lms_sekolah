<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LMS Siswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    x-data="loadingScreen()"
    x-init="init()"
    class="bg-gray-100 text-gray-800"
>

<!-- =====================
     MINIMAL LOADING SCREEN
===================== -->
<div
    x-show="loading"
    x-transition.opacity.duration.300ms
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-white"
>

    <div class="text-center space-y-4">

        <!-- LOGO SEKOLAH -->
        <img
            src="{{ asset('images/logo-sekolah.png') }}"
            alt="Logo Sekolah"
            class="w-16 h-16 mx-auto object-contain"
            onerror="this.style.display='none'"
        >

        <!-- FALLBACK TEXT -->
        <div class="text-xl font-semibold text-gray-800">
            LMS SMK 8
        </div>

        <!-- MOTIVASI -->
        <p class="text-sm text-gray-500 max-w-xs mx-auto">
            <span x-text="quote"></span>
        </p>

        <!-- DOT LOADER -->
        <div class="flex justify-center gap-2 pt-2">
            <span class="dot"></span>
            <span class="dot animation-delay-150"></span>
            <span class="dot animation-delay-300"></span>
        </div>

    </div>
</div>

<!-- =====================
     NAVBAR
===================== -->
<header class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-lg">LMS Sekolah</h1>

    <div class="flex items-center gap-4">
        <span class="text-sm">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-600 hover:underline">
                Logout
            </button>
        </form>
    </div>
</header>

<!-- =====================
     CONTENT
===================== -->
<main class="p-6">
    @yield('content')
</main>

<!-- =====================
     SCRIPT
===================== -->
<script>
function loadingScreen() {
    return {
        loading: true,
        quote: '',
        quotes: [
            'Belajar hari ini untuk masa depan yang lebih baik.',
            'Setiap langkah kecil membawa perubahan besar.',
            'Ilmu adalah bekal terbaik dalam hidup.',
            'Terus belajar, jangan menyerah.',
            'Kesuksesan dimulai dari kemauan belajar.'
        ],

        init() {
            this.quote = this.quotes[Math.floor(Math.random() * this.quotes.length)];

            // loading awal
            setTimeout(() => this.loading = false, 600);

            // loading saat pindah halaman
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    this.loading = true;
                });
            });
        }
    }
}
</script>

<!-- =====================
     STYLE
===================== -->
<style>
.dot {
    width: 8px;
    height: 8px;
    background: #111827;
    border-radius: 50%;
    animation: bounce 1.4s infinite ease-in-out both;
}

.animation-delay-150 {
    animation-delay: .15s;
}
.animation-delay-300 {
    animation-delay: .3s;
}

@keyframes bounce {
    0%, 80%, 100% {
        transform: scale(0);
        opacity: 0.3;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

</body>
</html>

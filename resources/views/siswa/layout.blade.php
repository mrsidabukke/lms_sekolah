<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LMS Siswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
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

    <!-- Main content -->
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>

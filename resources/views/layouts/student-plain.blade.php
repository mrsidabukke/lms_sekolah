<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LMS Siswa</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">

<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">
        <h1 class="text-xl font-bold text-indigo-600">LMS Sekolah</h1>
        <div class="text-sm text-gray-600">Siswa</div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-8">
    @yield('content')
</main>

</body>
</html>

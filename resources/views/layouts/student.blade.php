<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LMS Siswa</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    @include('components.sidebar')

    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

</body>
</html>

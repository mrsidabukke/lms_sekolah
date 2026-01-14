<!DOCTYPE html>
<html>
<head>
    <title>Laravel API Status</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial;
        }
        .success { color: lime; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Laravel LMS API</h2>

    <ul>
        <li>POST /api/login → Login semua role</li>
        <li>POST /api/admin/login → Login admin</li>
        <li>POST /api/admin/register-admin</li>
        <li>POST /api/admin/register-guru</li>
        <li>POST /api/admin/register-siswa</li>
    </ul>

    <p id="api-status">Checking API...</p>

    <script>
        fetch('/api-connect')
            .then(res => res.text())
            .then(text => {
                document.getElementById('api-status').innerHTML =
                    '<span class="success">' + text + '</span>';
            })
            .catch(() => {
                document.getElementById('api-status').innerHTML =
                    '<span class="error">API ERROR</span>';
            });
    </script>
</body>
</html>

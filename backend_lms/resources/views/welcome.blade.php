<!DOCTYPE html>
<html>
<head>
    <title>Laravel API Status</title>
    <style>
        body {
            background-color: black;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <p id="api-status">Loading...</p>

    <script>
        fetch('/api-connect')
            .then(res => res.text())
            .then(text => {
                document.getElementById('api-status').innerHTML = text;
            })
            .catch(err => {
                document.getElementById('api-status').innerHTML = '<span class="error">API error!</span>';
            });
    </script>
</body>
</html>

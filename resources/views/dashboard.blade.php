<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url={{ route('admin.dashboard') }}">
    <title>Mengalihkan ke Dashboard MUSEWANGI...</title>
</head>
<body style="background:#F8F5ED; font-family:sans-serif; display:flex; justify-content:center; align-items:center; min-height:100vh;">
    <script>
        window.location.replace("{{ route('admin.dashboard') }}");
    </script>
</body>
</html>

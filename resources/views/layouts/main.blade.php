<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Klinik Pratama UM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-96x96.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    @stack('page-css')
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="@yield('body-class')"> @yield('content') <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
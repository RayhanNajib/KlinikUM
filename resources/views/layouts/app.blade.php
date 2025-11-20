<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Klinik Pratama UM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-96x96.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}"> 
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="d-flex" id="wrapper">
        
        @include('layouts.partials._sidebar') 
        
        <div id="page-content-wrapper">
            
            @include('layouts.partials._topbar') 
            
            <main class="container-fluid p-4 p-md-5"> @yield('content') 
            </main>

        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        });
    </script>

    @stack('page-scripts')
    
</body>
</html>
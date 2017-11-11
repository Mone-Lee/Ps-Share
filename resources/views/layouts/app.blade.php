<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>



    @yield('stylesheet')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        @if(config('app.debugWeb'))
            window.homeCUrl = 'http://127.0.0.1:8080/home/c/';
            window.homePUrl = 'http://127.0.0.1:8080/home/p/';
            window.adminCUrl = 'http://127.0.0.1:8080/admin/c/';
            window.adminPUrl = 'http://127.0.0.1:8080/admin/p/';
        @else
            window.homeCUrl = '{{url('home/c/')}}';
            window.homePUrl = '{{url('home/p/')}}';
            window.adminCUrl = '{{url('admin/c/')}}';
            window.adminPUrl = '{{url('admin/p/')}}';
        @endif
        
        
    </script>
</head>
<body>

    @yield('app')

    @yield('script')

</body>
</html>

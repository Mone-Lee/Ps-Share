<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Test</title>
        {{--<link href="{{ elixir('build/css/app.css') }}" rel="stylesheet">--}}
        <link href="http://localhost:8080/public/build/css/app.css" rel="stylesheet">
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
            ]); ?>;
            {{--window.homeCUrl = '{{url('home/c/')}}';--}}
            {{--window.homePUrl = '{{url('home/p/')}}';--}}
            {{--window.adminCUrl = '{{url('admin/c/')}}';--}}
            {{--window.adminPUrl = '{{url('admin/p/')}}';--}}
            window.homeCUrl = 'http://127.0.0.1:8080/home/c/';
            window.homePUrl = 'http://127.0.0.1:8080/home/p/';
            window.adminCUrl = 'http://127.0.0.1:8080/admin/c/';
            window.adminPUrl = 'http://127.0.0.1:8080/admin/p/';
        </script>
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>
        {{--<script src="{{ elixir('build/js/app.js') }}"></script>--}}
        <script src="http://localhost:8080/public/build/js/app.js"></script>
    </body>
</html>

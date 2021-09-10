<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('admin/dist-assets/images/logo.png')}}" type="image/ong" sizes="16x16">

    <!-- Templates  -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('admin/dist-assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/dist-assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />


    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body>
    <!-- <div id="app"> -->
        <main>
            @yield('content')
        </main>
    <!-- </div> -->

    <script src="{{ asset('admin/dist-assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/sidebar.compact.script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/customizer.script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/echarts.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/echart.options.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/dashboard.v2.script.min.js')}}"></script>
</body>
</html>

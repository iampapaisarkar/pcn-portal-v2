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
    <!-- <link href="{{ asset('admin/dist-assets/css/plugins/datatables.min.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('admin/plugin/toast.css') }}" rel="stylesheet">


    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <script src="{{ asset('admin/dist-assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <!-- Jquery Confirm CDN -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />   
</head>
<body>
    <!-- <div id="app"> -->
    @include('layouts.page_templates.app')
    <!-- </div> -->
    <script src="{{ asset('admin/dist-assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/sidebar.compact.script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/customizer.script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/echarts.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/echart.options.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/datatables.script.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{ asset('admin/dist-assets/js/scripts/dashboard.v2.script.min.js')}}"></script>
    <script src="{{ asset('admin/plugin/toast.js')}}"></script>

    <script>
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        // @if(Session::has('status'))
        //     toastr.success("{{ Session::get('status') }}");
        // @endif

        @if(Session::has('errors'))
            var errors = <?php echo Session::get('errors'); ?>;
            var errorKeys = Object.keys(errors);
            errorKeys.forEach(key => {

                errors[key].forEach(errorMessage => {
                    toastr.error(errorMessage);
                });
            });
        @endif 

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
</body>
</html>

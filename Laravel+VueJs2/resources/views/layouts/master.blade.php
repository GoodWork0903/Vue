<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alif Keys') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bs4/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/font-awesome.min.css') }}">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/starter-template.css') }}" rel="stylesheet">

</head>
<body>
    <!-- wrapper -->
    <div id="wrapper">
        <!-- navbar -->
        @include('layouts.navbar')

        <!--main -->
        <main role="main" class="container">
            @yield('content')
        </main>
    </div>
    <!-- End wrapper-->

    <!--routes -->
    @routes

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('bs4/js/jq/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('bs4/js/jq/popper.min.js') }}"></script>
    <script src="{{ asset('bs4/js/bootstrap.min.js') }}"></script>
</body>
</html>

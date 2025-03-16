<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
      
        <!-- Gentelella -->
        
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <title>Relatório por período - @yield('title')</title>

    </head>
    <body  class="nav-md" id="app">
        <div class="container body">
            <div class="">
                @yield('main_container')
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
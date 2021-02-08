<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{{ csrf_token() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Seara Contabilidade - Sistema de Clientes </title>
  <link rel="icon" href="{{ asset('img/favicon.png')}}">
  <!-- Gentelella -->
  <link href="{{ asset('css/gentelella.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <!-- <link href="gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> -->
  <style type="text/css">
    .navbar{
      background: #D9D9D9;
    }

  </style>

  @stack('stylesheets')

</head>

<body class="login">
  @include('layouts.header_app')

  <div class="container body">

    <div class="main_container">

     @yield('content')

    </div>

  </div>
 
  <!-- Custom Theme Scripts -->

  <script>
    var SearaApp = {};

    SearaApp.assetURL = "{{ asset('') }}";
    SearaApp.baseURL = "{{ url('')  }}";
  </script>
  
  <script src="{{ asset("js/gentelella.min.js") }}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  @stack('scripts')

</body>
</html>

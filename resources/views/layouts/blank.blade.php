<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Gentellela Alela! | </title>

  <!-- Gentelella -->
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">

  <link href="gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="gentelella/build/css/custom.min.css" rel="stylesheet">
  <!-- <link href="gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> -->

  <!-- jQuery -->
  <script src="gentelella/vendors/jquery/dist/jquery.min.js"></script>

  @stack('stylesheets')

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      @include('includes/sidebar')

      @include('includes/topbar')

      @yield('main_container')

    </div>
  </div>

  <!-- Custom Theme Scripts -->
  <script src="{{ asset("js/gentelella.min.js") }}"></script>

  @stack('scripts')

</body>
</html>

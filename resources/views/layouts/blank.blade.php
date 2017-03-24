<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Gentellela Alela! | </title>

  <!-- Bootstrap -->
  <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset("css/font-awesome.min.css") }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">

  <link href="gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="gentelella/build/css/custom.min.css" rel="stylesheet">

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

  <!-- jQuery -->
  <!-- <script src="{{ asset("js/jquery.min.js") }}"></script> -->
  <!-- Bootstrap -->
  <!-- <script src="{{ asset("js/bootstrap.min.js") }}"></script> -->
  <!-- Custom Theme Scripts -->
  <!-- <script src="{{ asset("js/gentelella.min.js") }}"></script> -->


  <!-- jQuery -->
  <script src="gentelella/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="{{asset("gentelella/vendors/fastclick/lib/fastclick.js")}}"></script>
  <!-- NProgress -->
  <script src="gentelella/vendors/nprogress/nprogress.js"></script>
  <!-- jQuery Smart Wizard -->
  <script src="{{asset("gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js")}}"></script>
  <!-- Custom Theme Scripts -->
  <script src="gentelella/build/js/custom.min.js"></script>

  @stack('scripts')

</body>
</html>

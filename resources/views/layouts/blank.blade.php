<!DOCTYPE html>
<html lang="pt_BR">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{{ csrf_token() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Dasboard Seara Contabilidade</title>

  <!-- Gentelella -->
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">

  <script type="text/javascript">
    var url_project = "{{url('/')}}";
    var id_user         = '{{Auth::user()->id}}';
    var id_company      = '{{Auth::user()->user_id_company}}';
  </script>

  @stack('stylesheets')

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      @include('includes/sidebar')

      @include('includes/topbar')

      @yield('main_container')

      <!-- footer content -->
      @include('footer')
      <!-- /footer content -->

    </div>
  </div>

  
  <script>
    var SearaApp = {};

    SearaApp.assetURL = "{{ asset('') }}";
    SearaApp.baseURL = "{{ url('') }}/";
  </script>

  <!-- Custom Theme Scripts -->
  <script src="{{ asset("js/gentelella.min.js") }}"></script>
  
  <script>
  $("body").tooltip({
    selector: '[data-toggle="tooltip"]'
  });
  </script>

  @stack('scripts')

</body>
</html>

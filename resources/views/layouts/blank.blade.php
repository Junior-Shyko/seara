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

  <title>{{ $title ?? 'Dasboard Seara Contabilidade' }}</title>

  <!-- Gentelella -->
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">
  {{-- <link rel="icon" href="{{ asset('css/plugins/animate.min.css')}}"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.0/animate.min.css" 
  integrity="sha512-wyfUxKCJqlTFPc9qJy328AyR3g0cY8m/zQ6SQJdDA1QMV+ZWRHKRtmhv946ijpeZUEyFpzo4dILZXtkoaT+0sg=="
   crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script type="text/javascript">
    var url_project_teste = "{{url('seara/public/')}}";
    var id_user         = '{{Auth::user()->id}}';
    var id_company      = '{{Auth::user()->user_id_company}}';
  </script>

  @stack('stylesheets')
  

</head>

<body class="nav-md" id="app">
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
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

  <script src="{{ asset("js/gentelella.min.js") }}"></script>
  
  <script>
  $("body").tooltip({
    selector: '[data-toggle="tooltip"]'
  });
  </script>

  @stack('scripts')
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  </script>
</body>
</html>

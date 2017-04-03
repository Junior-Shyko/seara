<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Seara Contabilidade - Sistema de Clientes </title>

  <!-- Gentelella -->
  <link href="{{ asset('css/gentelella.min.css') }}" rel="stylesheet">

  <link href="{{ asset('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="gentelella/build/css/custom.min.css" rel="stylesheet">
  <!-- <link href="gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> -->
  <style type="text/css">
    .navbar{
      background: #D9D9D9;
    }

  </style>
  <!-- jQuery -->
  <script src="gentelella/vendors/jquery/dist/jquery.min.js"></script>

  @stack('stylesheets')

</head>

<body class="login">
  @include('layouts.header_app')
  
  <div class="container body">
  <div class="jumbotron ">
      <div class="container">
        <h2>Seja bem vindo ao cadastro dos Cliente da Seara Contabilidade.</h2>
       
        <div class="col-md-2">
          <img src="{{asset('img/avatarBussiness.jpg')}}" width="128">
        </div>
        <div class="col-md-10">
          Se você está nessa página significa que você é um cliente e deve fazer o <strong>cadastro da sua igreja</strong> e depois o <strong>seu cadastro</strong>.
          <br>
          <br>
          <p>Qualquer Dúvida você pode clicar no link <strong>DÚVIDAS</strong> na parte superior direita dessa página.</p>
          Agora vamos iniciar o seu cadastro.
        </div>
       
          
          
        
        
      </div>
    </div>  
    <div class="main_container">

     @yield('content')

    </div>

  </div>

  <!-- Custom Theme Scripts -->

  <script src="{{ asset("js/gentelella.min.js") }}"></script>
  <script src="{{ asset("js/register.min.js") }}"></script>

  @stack('scripts')

</body>
</html>

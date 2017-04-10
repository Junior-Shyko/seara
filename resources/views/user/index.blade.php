@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            
            <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Usuários <small>todos usuários da Igreja</small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-md-12">
              <button class="btn btn-primary pull-right">Novo</button>
            </div>
                  <div class="x_content">
                    <div class="panel panel-primary">
                      <div class="panel-body">
                        <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Nome</th>
                          <th>E-mail</th>
                          <th>Perfil</th>
                          <th>Empresa</th>
                          <th>Data Cadastro</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($users as $user)
                        @php
                       
                          $name_profile = \App\FunctionGeneral::getNameProfile( $user->user_id_profile );
                        @endphp
                        <tr>
                          <td>{{ $user->name}}</td>
                          <td>{{ $user->email}}</td>
                          <td>{{ $name_profile->profile_name }}</td>
                          <td>{{ $user->company_fantasy}}</td>
                          <td>{{ date('d/m/Y' , strtotime($user->created_at))}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                      </div>
                      <div class="panel-footer">Todos usuários</div>
                    </div>    
                    

                  </div>
                </div>
              
            </div>
           
        </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <footer>
        <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

@endsection

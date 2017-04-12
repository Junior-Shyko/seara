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
        @include('msg.message')
        <div class="x_title">
          <h2>Usuários <small>todos usuários da Igreja</small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="col-md-12">
          <button class="btn btn-primary pull-right">Novo</button>
        </div>
        <div class="x_content">
          <div class="panel">
            <div class="panel-body">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Data Cadastro</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  @php

                  $name_profile = \App\FunctionGeneral::getNameProfile( $user->user_id_profile );
                  /* CONFIGURAÇÃO PARA O MODAL DE DELETE*/
                  $modal_id_delete = "DeleteUser_".$user->id;
                  $description_modal = "Excluir Usuário";
                  $url_route = "users/".$user->id;
                  $text_delete = "Deseja realmente excluir esse usuário?";
                  $name_camp = "id";
                  $value_camp = $user->id;

                  @endphp
                  <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $name_profile->profile_name }}</td>

                    <td>{{ date('d/m/Y' , strtotime($user->created_at))}}</td>
                    <td>
                      <a href="{{url('users/'.base64_encode($user->id).'/edit')}}" class="btn btn-default" title="Editar"  ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      <a href="#{{$modal_id_delete}}" class="btn btn-danger" title="Excluir" data-toggle="modal"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                    </td>
                  </tr>
                  @include('modals.modal_delete')
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="panel-footer"> 
              <strong>Empresa: </strong> {{$users[0]->company_fantasy}}
              <br>
              <strong>Total de usuários: </strong> {{count($users)}}

            </div>
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

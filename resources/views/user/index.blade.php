@extends('layouts.blank')

@push('stylesheets')
  <!-- Example -->
  <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="x_panel">
      <div class="x_title">
        <h2>Usuários <small>Funcionários da empresa</small></h2>

        {{-- Novo Usuário --}}
        <button class="btn btn-primary pull-right" onclick="createUser()" data-toggle="tooltip" data-placement="bottom"
        data-original-title="Novo Usuário">
        <i class="fa fa-plus" aria-hidden="true"></i>
      </button>

      {{-- Atualizar --}}
      <button class="btn btn-primary pull-right" onclick="usersDataTable.reloadTable()" data-toggle="tooltip" data-placement="bottom"
      data-original-title="Atualizar">
      <i class="fa fa-refresh" aria-hidden="true"></i>
    </button>

    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="right-col">
      <table id="users-table" class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfil</th>
            <th>Data de Cadastro</th>
            <th>Ações</th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>
</div>
<!-- /page content -->

@component('components.modal-form', ['id' => 'modal-form', 'btnID' => 'modal-form-btn', 'title' => 'Cadastrar Usuário'])
  <!-- Formulário  -->
  <form id="form-user" data-parsley-validate="" >

    <input type="hidden" name="user_id_company" value="{{ Auth::user()->user_id_company }}">
    <input type="hidden" name="user_id_profile" value="2">

    {{-- Nome e Sexo --}}
    <div class="form-group">
      <div class="col-md-8 col-sm-8 col-xs-12">
        <label>Nome Completo</label>
        <input type="text" class="form-control" name="name">
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12">
        <label>Sexo</label>
        <select class="form-control" name="user_sex">
          <option>Masculino</option>
          <option>Feminino</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-4 col-sm-4 col-xs-4">
        <label>CPF</label>
        <input type="text" class="form-control" name="user_cpf">
      </div>
      <div class="col-md-4 col-sm-4 col-xs-4">
        <label>Data de Nascimento</label>
        <input type="text" class="form-control" name="user_birth">
      </div>
      <div class="col-md-4 col-sm-4 col-xs-4">
        <label>Telefone</label>
        <input type="text" class="form-control" name="user_phone">
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-8 col-sm-8 col-xs-8">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" class="form-control" placeholder="Email" name="email">
      </div>
       <div class="col-md-4 col-sm-4 col-xs-4">
        <label>Email</label>
        <select name="user_id_profile"  class="form-control" id="">
          @foreach($profile as $profiles)
            <option value="{{$profiles->profile_id}}" >{{$profiles->profile_name}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Senha</label>
        <input type="password" class="form-control" placeholder="Seanha" name="password">
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Confirme a Senha</label>
        <input type="password" class="form-control" placeholder="Seanha">
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-3 col-sm-3 col-xs-12">
        <label>CEP</label>
        <input type="text" class="form-control" name="user_addr_cep">
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Rua</label>
        <input type="text" class="form-control" name="user_addr_street">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <label>Número</label>
        <input type="text" class="form-control" name="user_addr_number">
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Complemento</label>
        <input type="text" class="form-control" name="user_addr_complement">
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Bairro</label>
        <input type="text" class="form-control" name="user_addr_district">
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Cidade</label>
        <input type="text" class="form-control" name="user_addr_city">
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label>Estado</label>
        <input type="text" class="form-control" name="user_addr_state">
      </div>
    </div>
  </form> <!-- Fim do form -->
@endcomponent

@endsection

@push('stylesheets')
  <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/notify.min.css')}}">
@endpush

@push('scripts')
  <script type="text/javascript" language="javascript" src="{{asset('js/users.min.js')}}"></script>

  <script>

  var colunas = [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'email', name: 'email' },
    { data: 'profile_name', name: 'profile_name' },
    { data: 'created_at', name: 'created_at' },
    { data: 'action', name: 'action', orderable: false, searchable: false }
  ];

  var usersDataTable = new SearaTable('users-table', "{{ route('users.datatables') }}", colunas, 'usuário', 'usuários');

  // Acesso a recursos
  var user = new ResourceModel("{{ route('users.index') }}");

  </script>
@endpush

{{-- $('#modal-form .modal-content').LoadingOverlay('hide'); --}}

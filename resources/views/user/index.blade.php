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
        <button class="btn btn-primary pull-right" onclick="" data-toggle="tooltip" data-placement="bottom"
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
    { data: 'user_id_profile', name: 'user_id_profile' },
    { data: 'created_at', name: 'created_at' },
    { data: 'action', name: 'action', orderable: false, searchable: false }
  ];

  var usersDataTable = new SearaTable('users-table', "{{ route('users.datatables') }}", colunas, 'usuário', 'usuários');

  // Acesso a recursos
  var user = new ResourceModel("{{ route('users.index') }}");

  </script>
@endpush

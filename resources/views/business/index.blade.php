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
          <h2>Clientes <small>gerenciamento de clientes</small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="col-md-12">
          <a href="{{url('companies/create')}}"><button class="btn btn-primary pull-right">Cadastrar Cliente</button></a>
        </div>
        <div class="x_content">
          <div class="panel">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-hover" id="company-table">
                  <thead>
                    <tr>
                      <th>Razão Social</th>
                      <th>Fantasia</th>
                      <th>CNPJ</th>
                      <th>Responsável</th>
                      <th>Data Cadastro</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="panel-footer">
              

            </div>
          </div>


        </div>
      </div>

    </div>

  </div>
</div>
<!-- /page content -->

@endsection

@push('scripts')

<script>
  
$(document).ready(function(){
  var colunas = [
    { data: 'company_name', name: 'company_name' },
    { data: 'company_fantasy', name: 'company_fantasy' },
    { data: 'company_cnpj', name: 'company_cnpj' },
    { data: 'company_manager', name: 'company_manager' },
    { data: 'created_at', name: 'created_at' },
    { data: 'action', name: 'action', orderable: false, searchable: false }
  ];

  var companyTable = new SearaTable('company-table', 'companies/dataTable', colunas, 'cliente', 'clientes');

  companyTable.loadTable();
});

</script>

@endpush

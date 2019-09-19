@extends('layouts.blank')

@section('main_container')

<!-- page content -->
<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Clientes <small>informações dos clientes</small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="col-md-12">
          <a href="{{url('companies/create')}}"><button class="btn btn-primary pull-right">Novo</button></a>
        </div>
        <div class="x_content">
          <div class="panel">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-hover" id="customer-table">
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
  
$(document).ready(function() {

  var columns = [
    { data: 'customer_name', name: 'customer_name' },
    { data: 'customer_fantasy', name: 'customer_fantasy' },
    { data: 'customer_cnpj', name: 'customer_cnpj' },
    { data: 'customer_admin', name: 'customer_admin' },
    { data: 'created_at', name: 'created_at' },
    { data: 'action', name: 'action', orderable: false, searchable: false }
  ];

  var customerTable = new SearaTable('customer-table', 'clientes/dataTable', columns, 'cliente', 'clientes');

  customerTable.loadTable();
});

</script>

@endpush

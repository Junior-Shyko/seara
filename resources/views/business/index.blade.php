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
          <h2>Igreja <small>informações da Igreja</small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="col-md-12">
          <a href="{{url('companies/create')}}"><button class="btn btn-primary pull-right">Novo</button></a>
        </div>
        <div class="x_content">
          <div class="panel">
            <div class="panel-body">
              <div class="table-responsive">
                 <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Responsável</th>
                    <th>Data Cadastro</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($company as $companys)
                  
                  <tr>
                    <td>{{ $companys->company_name }}</td>
                    <td>{{ $companys->company_cnpj }}</td>
                    <td>{{ $companys->company_cnpj }}</td>

                    <td>{{ date('d/m/Y' , strtotime($companys->created_at))}}</td>
                    <td>
                      <a href="{{url('companies/'.$companys->company_id.'/edit')}}" class="btn btn-default" title="Editar"  ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      
                    </td>
                  </tr>
                  
                  @endforeach
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

<!-- footer content -->
<footer>
  <div class="pull-right">
    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->

@endsection

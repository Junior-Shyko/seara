@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset('css/myFile.min.css') }}" rel="stylesheet">" rel="stylesheet">-->
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
                        <a href="{{ url('companies/create') }}"><button class="btn btn-primary pull-right">Cadastrar
                                Cliente</button></a>
                    </div>
                    <div class="x_content">
                        @include('msg.message')
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

    @include('modals.customer.edit')
    @include('modals.company.alterAccess')

@endsection

@push('scripts')
    <script type="text/javascript" language="javascript" src="{{ asset('js/customer.min.js') }}"></script>
@endpush

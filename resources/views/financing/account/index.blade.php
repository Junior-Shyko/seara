@extends('layouts.blank')

@push('stylesheets')
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">

            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Contas <small>gerenciamento de contas</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12">
                        <button id="create-account-btn" class="btn btn-primary pull-right">Cadastrar Conta</button>
                    </div>
                    <div class="x_content">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="account-table">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Tipo</th>
                                            <th>Saldo</th>
                                            <th>Criado em</th>
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

    @include('modals.financing.account.create')

@endsection

@push('scripts')
    <script type="text/javascript" language="javascript" src="{{asset('js/financing/account.min.js')}}"></script>
@endpush
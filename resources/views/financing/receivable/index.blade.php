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
                        <h2 data-cy="title">Contas a Receber <small>gerenciamento de contas a receber</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12">
                        <button id="create-receivable-btn" class="btn btn-primary pull-right" data-cy="create-btn">Cadastrar Conta</button>
                    </div>
                    <div class="x_content">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" data-cy="table" id="table-receivable">
                                        <thead>
                                        <tr>
                                            <th>Vencimento</th>
                                            <th>Dt. Pgto</th>
                                            <th>Descrição</th>
                                            <th>Categoria</th>
                                            <th>Conta</th>
                                            <th>Valor</th>
                                            <th>Cliente</th>
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

    @include('financing.receivable.modal_receivable')
    @include('financing.receivable.modal_pay_receivable')

@endsection

@push('scripts')
    <script type="text/javascript" language="javascript" src="{{elixir('js/financing/receivable.min.js')}}"></script>
@endpush

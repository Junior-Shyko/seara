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
                                            <th>Descrição</th>
                                            <th>Valor</th>
                                            <th>Vencimento</th>
                                            <th>Cliente</th>
                                            <th>Dt. Pagamento</th>
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

{{--    @include('modals.financing.income_category.create')--}}

@endsection

@push('scripts')
{{--    <script type="text/javascript" language="javascript" src="{{elixir('js/financing/income_category.min.js')}}"></script>--}}
@endpush

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
                        <h2 data-cy="title">Pagamentos <small>gerenciamento de pagamentos recebidos</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <button id="create-payment-btn" class="btn btn-primary pull-right" data-cy="create-btn">Cadastrar Pagamento</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        @include('financing.payment.includes.advanced_search')

                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" data-cy="table" id="table-payment">
                                        <thead>
                                        <tr>
                                            <th>Responsável</th>
                                            <th>Cliente</th>
                                            <th>Data de Pagamento</th>
                                            <th>Data de Cadastro</th>
                                            <th>Valor</th>
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
    <script type="text/javascript" language="javascript" src="{{elixir('js/financing/payment.min.js')}}"></script>
@endpush

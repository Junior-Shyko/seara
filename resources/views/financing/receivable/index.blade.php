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
                    <div class="col-md-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse1">> Pesquisa Avançada</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form id="advanced-search-receivable">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label>Cliente</label>
                                                        <select name="customer" class="form-control select2">
                                                            <option value=""></option>
                                                            <option value="none">Sem cliente</option>
                                                            @foreach($companies as $company)
                                                                <option value="{{ $company->company_id }}">
                                                                    {{ $company->company_manager }} / {{ $company->company_name ?? $company->company_fantasy }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Status</label>
                                                        <select name="status" class="form-control select2">
                                                            <option value=""></option>
                                                            <option value="all">Todas</option>
                                                            <option value="effective">Efetivada</option>
                                                            <option value="pending">Pendente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Data de pagamento de</label>
                                                        <input type="text" class="form-control date-mask" name="payment_date_start">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Data de pagamento até</label>
                                                        <input type="text" class="form-control date-mask" name="payment_date_end">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Vencimento de</label>
                                                        <input type="text" class="form-control date-mask" name="due_date_start">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Vencimento até</label>
                                                        <input type="text" class="form-control date-mask" name="due_date_end">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <th>Valor Pago</th>
                                            <th>Responsável</th>
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
        <script type="text/javascript" language="javascript" src="{{asset('js/financing/receivable.min.js')}}"></script>
    <script>

        $(document).ready(function(){
            $('#modal-pay-receivable').on('shown.bs.modal', function () {
                $('#date_payment').focus();
            });
        });
    </script>
@endpush

<div class="row">
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
                        <form id="advanced-search-payment">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label>Cliente</label>
                                        <select name="customer" class="form-control select2">
                                            <option value=""></option>
                                            <option value="none">Sem cliente</option>
                                            {{--                                                            @foreach($companies as $company)--}}
                                            {{--                                                                <option value="{{ $company->company_id }}">--}}
                                            {{--                                                                    {{ $company->company_manager }} / {{ $company->company_name ?? $company->company_fantasy }}--}}
                                            {{--                                                                </option>--}}
                                            {{--                                                            @endforeach--}}
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
</div>

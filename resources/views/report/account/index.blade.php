@extends('layouts.blank')

@push('stylesheets')
@endpush

@section('main_container')
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 data-cy="title">Relatório <small>dívidas e pagamentos</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nome da conta</label>
                                    <select name="entries_id_account" id="cod_account" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">
                                            {{ $account->accountlaunch_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="">Data Inicial</label>
                                        <input type="text" name="dateInitial" class="form-control date-mask" id="dateInitial">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Data Final</label>
                                        <input type="text" name="dateEnd" class="form-control date-mask" id="dateEnd">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12" style="margin-top: 10px">
                                        <button class="btn btn-primary btn-block">Pesquisar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush

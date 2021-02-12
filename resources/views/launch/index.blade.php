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
                    <h2>Conta <small>Criar conta de lançamento para o caixa</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left" id="form-account-launch">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label">Tipo da conta</label>
                                <select name="accountlaunch_type" id="" class="form-control">
                                    <option value="">--Selecione--</option>
                                    <option value="1">Receitas</option>
                                    <option value="2">Despesa</option>
                                </select>
                            </div>
                            <div class="col-sm-9">
                                <label for="">Nome da conta</label>
                                <div class="input-group">
                                    <input type="text" name="accountlaunch_name" class="form-control" placeholder="Nome da conta">
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="btn-save-account-launch">Salvar</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="divider-dashed"></div>
                        <input type="text" name="accountlaunch_id_user" value="{{Auth::user()->id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="x_panel">
        @include('msg.message')
        <div class="x_title">
            <h2>Conta <small>Todas as contas</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="right-col">
                <table id="receipts-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Emitente</th>
                            <th>Referente a</th>
                            <th>Valor</th>
                            <th>Local</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
{{-- @include('modals.receipt.receipt')
@include('modals.receipt.delete') --}}
@endsection
@push('stylesheets')
{{-- 
<link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
--}}
@endpush
@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/launch/account_launch.min.js')}}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<link href="{{ url("css/entry.min.css") }}" rel="stylesheet">
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            @include('msg.message')
            <div class="x_panel">
                <div class="x_title">
                    <h2>Banco <small>Criar banco para cadastro de contas bancárias</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                 <div class="row">
                     <div class="col-md-12">
                        <label for="">Nome do banco</label>
                        <div class="input-group">
                            <form id="formInputBank">
                                <input type="text" name="company_name" class="form-control" id="inputBank">
                            </form>
                            <span class="input-group-btn">
                            <button type="button" title="Cadastrar um banco" class="btn btn-primary" id="btnPlusBank">
                                <i class="fa fa-save"></i> Cadastrar
                            </button>
                            </span>
                        </div>
                     </div>
                 </div>
                </div>
            </div>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Conta <small>Todas as contas</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="right-col">
                <table id="table-bank" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome do banco</th>
                            <th>Criado em</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
{{-- @include('modals.launch.modal_account_launch', [$typeAccount]) --}}
@component('components.modal_delete_comp')
<form action="{{url('launch/account/delete')}}" method="POST">
    {!! csrf_field() !!}
    <p>
    <h4 class="text-danger">
        Deseja realmente excluir essa conta do movimento de Caixa?
    </h4>
    </p>
    <p>
    <h4 id="nameAccountDeleteModal">Conta: </h4>
    <h4 id="typeAccountDeleteModal">Tipo da Conta: </h4>
    </p>
    <input type="hidden" name="id" id="idAccountLaunch">
    <input type="hidden" name="table" value="account_launches">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        <button type="submit" class="btn btn-danger"> EXCLUIR </button>
    </div>
</form>
@endcomponent
@endsection
@push('stylesheets')
{{-- 
<link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
--}}
@endpush
@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/bank/bank.js')}}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
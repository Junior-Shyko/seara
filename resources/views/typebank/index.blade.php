@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<link href="{{ url("css/entry.min.css") }}" rel="stylesheet">
<style>
    .border-update {
        border: 1px solid #4569cf;
        box-shadow: inset 0 0 0.5em #bcc9e5, 0 0 0.2em #0c46e9;
    }
</style>
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            @include('msg.message')
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tipo de conta bancaria <small>Criar os tipos de conta bancaria.</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                 <div class="row">
                     <div class="col-md-12">
                        <label for="">Nome do tipo da conta.</label>
                        <form id="formInputBank">
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" id="inputTypeBank">
                            <span class="input-group-btn">
                            <button type="button" title="Cadastrar tipo bancário" class="btn btn-primary" id="btnPlusBank">
                                <i class="fa fa-save"></i> <span id="nameButtonTypeBank">Cadastrar</span>
                            </button>
                            </span>
                        </div>
                        <input type="hidden" name="idTypeBank" id="idTypeBank">
                        <input type="hidden" name="type_action" id="typeActionType" value="create">
                    </form>
                     </div>
                 </div>
                </div>
            </div>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Tipos de conta <small>Todos os tipos de conta bancária</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="right-col">
                <table id="table-type-bank" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Conta bancária</th>
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
{{-- @include('components.modal-delete') --}}
@component('components.modal-delete', [
    'id'    => 'modalDeleteTypeAccontBank',
    'class' => '',
])
    @slot('title', 'Excluir conta bancaria')

    @slot('slot')
       Deseja realmente excluir essa conta bancaria?
       <p>
           Ao excluir você entende o risco.
       </p>
    @endslot

    @slot('inputs')
       <input type="hidden" name="delete_type_account_bank" id="delete_type_account_bank">
    @endslot

    @slot('idBtnModal')
        btn_delete_type_account_bank
    @endslot
@endcomponent
@endsection
@push('stylesheets')
{{-- 
<link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
--}}
@endpush
@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/typeBank/typeBank.min.js')}}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
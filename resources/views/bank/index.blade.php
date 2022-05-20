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
                        <form id="formInputBank">
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" id="inputBank">
                            <span class="input-group-btn">
                            <button type="button" title="Cadastrar um banco" class="btn btn-primary" id="btnPlusBank">
                                <i class="fa fa-save"></i> <span id="nameButtonBank">Cadastrar</span>
                            </button>
                            </span>
                        </div>
                        <input type="hidden" name="id_bank" id="id_bank">
                        <input type="hidden" name="type_action" id="typeActionBank" value="create">
                    </form>
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
{{-- @include('components.modal-delete') --}}
@component('components.modal-delete', [
    'id'    => 'modalDeleteBank',
    'class' => '',
])
    @slot('title', 'Excluir Banco')

    @slot('slot')
       Deseja realmente excluir esse banco?
       <p>
           Ao excluir um banco poderá afetar algumas contas banárias. Ao excluir você entende o risco.
       </p>
    @endslot

    @slot('inputs')
       <input type="hidden" name="delete_bank" id="delete_bank">
    @endslot

    @slot('idBtnModal')
        btnDeleteBank
    @endslot
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
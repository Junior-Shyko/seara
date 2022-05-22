@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.11/jquery.datetimepicker.min.css" rel="stylesheet">
@endpush
@section('main_container')
<div class="right_col" role="main" style="min-height: 948px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Conta Bancaria</h3>
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Criar conta bancaria</h2>
                        <a href="#" title="Lançar movimento no caixa" class="btn btn-primary navbar-right">
                            Lançar Movimento
                        </a>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        {{-- FORMULÁRIO PARA CADASTRO E EDIÇÃO --}}
                        <form id="formAccountBank">
                            @include('accountBank.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Suas contas <small>Todas as suas contas bancarias</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="right-col">
                            <table id="table-account-bank" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome do banco</th>
                                        <th>Tipo de conta</th>
                                        <th>Valor Atual</th>
                                        <th>N. Conta</th>
                                        <th>N. Agência<th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@component('components.modal-delete', [
    'id'    => 'modalDeleteAccountBank',
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
       <input type="text" name="delete_bank" id="delete_account_bank">
    @endslot

    @slot('idBtnModal')
        btnDeleteAccountBank
    @endslot
@endcomponent

{{-- MODAL DE EDIÇÃO --}}
@component('components.modal-edit', [
    'id'    => 'modalEditAccountBank',
    'class' => ''
])
    @slot('size')
        modal-lg
    @endslot
    @slot('title', 'Editar conta bancaria')

    @slot('slot')
       @include('accountBank.form')
    @endslot

    @slot('inputs')
       <input type="hidden" name="delete_bank" id="delete_bank">
    @endslot

    @slot('idBtnModal')
        btnDeleteBank
    @endslot
@endcomponent
{{-- FIM MODAL DE EDIÇÃO --}}

@endsection

@push('stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush
@push('scripts')
<script type="text/javascript" language="javascript" src="{{ asset('js/typeBank/typeBank.min.js') }}"></script>
    
@endpush

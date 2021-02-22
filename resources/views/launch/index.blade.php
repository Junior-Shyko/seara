@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<link href="{{ url("css/entry.min.css") }}" rel="stylesheet">
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        @include('msg.message')
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
                                <div class="input-group">
                                    <select name="accountlaunch_type" id="" class="form-control select2">
                                        @foreach($typeAccount as $typeAccounts)
                                        <option value="{{ $typeAccounts->id }}">
                                            {{ $typeAccounts->account_types_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalSaveType" title="Cadastar tipo de conta">
                                    <i class="fa fa-plus"></i>
                                    </button>
                                    </span>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="modalSaveType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Criar Tipo de conta</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Tipo de conta</label>
                                                            <input type="text" name="account_types_name" id="account_types_name" class="form-control" placeholder="Digite o tipo da conta">
                                                            <input type="hidden" name="account_types_id_user" id="account_types_id_user" value="{{Auth::user()->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="btn-save-type-account">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Nome da conta</label>
                                <input type="text" name="accountlaunch_name" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Referente</label>
                                <select name="account_launches_referring" class="form-control">
                                    <option value="">--Selecione--</option>
                                    <option value="Dizimo">Dízimo</option>
                                    <option value="Ofertas">Ofertas</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="">Histórico da conta</label>
                                <div class="input-group">
                                    <input type="text" name="accountlaunch_history" id="" class="form-control">
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="btn-save-account-launch">Salvar conta</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="divider-dashed"></div>
                        <input type="hidden" name="accountlaunch_id_user" value="{{Auth::user()->id}}">
                    </form>
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
                <table id="account-launch-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Código da Conta</th>
                            <th>Tipo da Conta</th>
                            <th>Nome da Conta</th>
                            <th>Histórico</th>
                            <th>Criada em</th>
                            <th>Criada por</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@include('modals.launch.modal_account_launch', [$typeAccount, $totalPrevius])
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
    <input type="text" name="id" id="idAccountLaunch">
    <input type="text" name="table" value="account_launches">
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
<script type="text/javascript" language="javascript" src="{{asset('js/launch/account_launch.min.js')}}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
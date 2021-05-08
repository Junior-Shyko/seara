@extends('layouts.blank')
@push('stylesheets')
<style>
    .img_edit {
        height: 100px;
        width: 100px;
    }
</style>
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">
    <div class="x_panel">
        @include('msg.message')
        <div class="x_title">
            <h2>ALTERAR LANÇAMENTO<small>Altere o registro ou os arquivos.</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="right-col">
                <div class="row">
                    <form action="{{url('lancar/'.$id)}}" method="POST" >
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Conta:</label>
                            <select name="entries_id_account" id="cod_account" class="form-control select2">
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->accountlaunch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Tipo de conta:</label> <br>
                            <h4 class="control-label text-primary" id="label_desc_type">
                                <strong>{{$launch[0]->account_types_name}}</strong>
                            </h4>
                        </div>
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Data</label>
                            <div class='input-group date'>
                                <input type='text' name="entries_date_launch" class="form-control date-mask"  id='dateRetroactive' value="{{ \Carbon\Carbon::parse($launch[0]->entries_date_launch)->format('d/m/Y')}} "/>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-6 form-group">
                            <label for="">Histórico:</label>
                            <input type="text"  name="entries_description" class="form-control" value="{{$launch[0]->entries_description}}">
                        </div>
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Valor:</label>
                            <input type="text" class="form-control" 
                            id="entries_value"
                            name="entries_value" value="{{number_format($launch[0]->entries_value,2,',','.')}}">
                        </div>
                        {{-- <div class="col-md-8 col-sm-6 form-group">
                            <label for="">Tipo de caixa:</label>
                            <div class="">
                                @if ($launch[0]->entries_bank == 0)
                                <label class="btn btn-primary">
                                    <input type="radio"  name="entries_bank" value="true"> Banco
                                    </label>
                                    <label class="btn btn-primary">
                                    <input type="radio" checked name="entries_bank" value="false"> Interno
                                    </label>
                                @else
                                <label class="btn btn-primary">
                                    <input type="radio"  checked name="entries_bank" value="true"> Banco
                                    </label>
                                    <label class="btn btn-primary">
                                    <input type="radio"  name="entries_bank" value="false"> Interno
                                    </label>
                                @endif
                                
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <hr>
                            <div class="form-group pull-right">
                                <a href="{{url('lancar')}}" class="btn btn-default">
                                <i class="fa fa-close"></i>
                                Sair
                                </a>
                                <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>
                                Salvar alteração
                                </button>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
                {{-- IMAGENS  --}}
            </div>
        </div>

        <div class="x_content">
            <div class="right-col">
                <div class="row">
                    <div class="x_title">
                        <div class="row">
                            <br>
                            <div class="ln_solid"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Arquivos <small>Todos os arquivos enviados.</small></h2>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-success pull-right"
                                    data-toggle="modal"
                                    data-id="{{$id}}"
                                    data-target="#modalUploadLaunch">
                                        <i class="fa fa-plus"></i>
                                        Adicionar
                                    </a>
                                <a href="{{url('lancar/'.$id.'/edit')}}"  class="btn btn-info pull-right" title="Atualizar arquivos">
                                    <i class="fa fa-refresh"></i>
                                </a>    
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Arquivo</th>
                                <th>Enviado</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                            <tr>
                                <td>
                                    <a href="{{url('/img/images/'.$file->file_launches_name)}}" target="_blanck">
                                        <img src="{{url('/img/images/'.$file->file_launches_name)}}" class="img_edit">
                                    </a>
                                </td>
                                <td>
                                    {{$file->created_at}}
                                </td>
                                <td>
                                    <a href="#modalDeleteComponent" data-toggle="modal" data-id="{{$file->id}}" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                        Excluir
                                    </a>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                        
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.modal_upload_launch')
@component('components.modal_delete_comp')
<form action="{{url('lancar/file/delete')}}" method="post">
    {!! csrf_field() !!}
    <div class="row">
      <div class="alert alert-danger">
        <h4 >
            Deseja realmente excluir esse arquivo?
        </h4>
        <small>Essa ação é inreversível, não dá para voltar atrás.</small>
      </div>
      <input type="hidden" name="id" id="idDelete">
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
          <button type="submit" class="btn btn-danger"> EXCLUIR </button>
      </div>
    </div>
</form>
@endcomponent
<!-- /page content -->
@endsection
@push('stylesheets')

<link rel="stylesheet" type="text/css" href="{{url('css/entry.min.css')}}">

@endpush
@push('scripts')
<script>
    var idAccont = '{{$launch[0]->entries_id_account}}';
    $('#cod_account').val(idAccont).trigger('change');
</script>
<script type="text/javascript" language="javascript" src="{{asset('js/launch/entry.min.js')}}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="row">
        <div class="tile_count">
          <div class="col-md-3 col-sm-6  tile_stats_count">
            <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Caixa Banco</span>
            <div class="count">{{number_format($totBanco,2,",",".")}}</div>
            <span class="count_bottom text-info">Valores do caixa Banco</span>
          </div>

          <div class="col-md-3 col-sm-6  tile_stats_count">
            <span class="count_top text-success"><i class="fa fa-money  text-success"></i> Caixa igreja</span>
            <div class="count">{{number_format($toalIgreja,2,",",".")}}</div>
            <span class="count_bottom text-success">Valores do caixa da igreja</span>
          </div>

          <div class="col-md-3 col-sm-6  tile_stats_count">
            <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Caixa Geral</span>
            <div class="count">{{number_format($totalGeral,2,",",".")}}</div>
            <span class="count_bottom text-info">Valor dos dois caixas juntos</span>
          </div>

          <div class="col-md-3 col-sm-6  tile_stats_count">
            <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Saldo Atual</span>
            <div class="count">{{number_format($saldo,2,",",".")}}</div>
            <span class="count_bottom text-info">Seu valor atual de caixa</span>
          </div>
        </div>

      </div>
      <div class="x_panel">
        @include('msg.message')
        <div class="x_title">
          <h2>LANÇAMENTO DE CAIXA <small>Seus últimos lançamentos</small></h2>
          <button class="btn btn-primary pull-right"  data-toggle="modal" data-target="#lancar_conta">Lançar Movimento</button>
          
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="right-col">
            <table id="entry-table" class="table table-hover">
              <thead>
                <tr>
                  <th>Dia</th>
                  <th>Histórico</th>
                  <th>Valor</th>
                  <th>Tipo</th>
                  <th>Lançado por</th>
                  <th>Ações</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
        
      </div>
    </div>
    {{-- @include('modals.entry.modal_lauch') --}}
    @include('modals.modal_box_entry')
    @include('modals.modal_upload_launch')
@component('components.modal_delete_comp')
<form action="{{url('lancar/delete')}}" method="post">
    {!! csrf_field() !!}
    <div class="row">
      <div class="alert alert-danger">
        <h4 >
            Deseja realmente excluir esse lançamento do caixa?
        </h4>
        <small>Essa ação é inreversível, não dá para voltar atrás.</small>
      </div>
      <div class="text-center">
        <h4>Histórico: <label  id="historyLaunchDeleteModal"></label></h4>
        <h4>Tipo: <label id="typeLaunchDeleteModal"></label> </h4>
      </div>
      <input type="hidden" name="id" id="idDelete">
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
          <button type="submit" class="btn btn-danger"> EXCLUIR </button>
      </div>
    </div>
</form>
@endcomponent


<!-- Modal -->
<div class="modal fade" id="modalInfoLaunch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Informação completo do lançamento</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <ul class="list-group">
              <li class="list-group-item day">Dia:</li>
              <li class="list-group-item his">Histórico:</li>
              <li class="list-group-item value">Valor:</li>
              <li class="list-group-item account">Conta: </li>
              <li class="list-group-item created">Criado:</li>
            </ul>
          </div>
          <div class="col-md-8">
            <div id="filesEntri">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
          <a id="linkEdit" class="btn btn-primary">
            <i class="fa fa-edit"></i> Alterar Lançamento
          </a>
      </div>
    </div>
  </div>
</div>
    <!-- /page content -->
@endsection

@push('stylesheets')
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush

@push('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/launch/entry.min.js')}}"></script>

{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
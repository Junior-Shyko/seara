@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
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
    <!-- /page content -->
@endsection

@push('stylesheets')
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush

@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/launch/entry.min.js')}}"></script>

{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
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
          <button class="btn btn-primary pull-right"  data-toggle="modal" data-target="#modal-entry">Lançar Movimento</button>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="right-col">
            <table id="entry-table" class="table table-hover">
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
    {{-- @include('modals.entry.modal_lauch') --}}
    @include('modals.modal_box_entry')
    <!-- /page content -->
@endsection

@push('stylesheets')
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush

@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/launch/entry.min.js')}}"></script>

{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
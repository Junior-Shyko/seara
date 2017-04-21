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
          <h2>Recibos <small>Recibos emitidos pela empresa</small></h2>
          <button class="btn btn-primary pull-right" onclick="createReceipt( {{ $company->company_id }} )">Novo Recibo</button>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="right-col">
            <table id="receipts-table" class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Recebido de</th>
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

    @include('modals.receipt.receipt')

   @include('footer')


@endsection

@push('stylesheets')
  <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/notify.min.css')}}">
@endpush

@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/mask.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('js/notify.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('js/receipt.min.js')}}"></script>

<script>
var datatablesURL = "{!! route('datatables.data') !!}";

</script>
@endpush

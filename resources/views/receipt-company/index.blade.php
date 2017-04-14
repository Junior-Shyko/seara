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
          <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_create_receipt">Novo Recibo</button>
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
              <tbody>
                @foreach ($receipts as $receipt)
                <tr>
                  <th scope="row">
                    {{ $receipt->receipt_id }}
                  </th>
                  <td>
                    {{ $receipt->receipt_received_from }}
                  </td>
                  <td>
                    {{ $receipt->receipt_reference }}
                  </td>
                  <td>
                    {{ $receipt->receipt_value }}
                  </td>
                  <td>
                    {{ $receipt->receipt_local }}
                  </td>
                  <td>
                    {{ $receipt->receipt_date->format('d/m/Y') }}
                  </td>
                  <td class="no-break">
                    <!-- Ação Editar -->
                    <button class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Editar Recibo">
                      <i class="fa fa-pencil"></i>
                    </button>
                    <!-- Ação Clonar -->
                    <button class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Clonar Recibo">
                      <i class="fa fa-clone"></i>
                    </button>
                    <!-- Ação Excluir -->
                    <button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Excluir Recibo">
                      <i class="fa fa-trash-o"></i>
                    </button>
                    <!-- Ação download -->
                    <a href="{{ url('recibo-empresa/'.$receipt->receipt_id.'/pdf?vias=1') }}" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-print"></i> 1 Via </a>
                    <a href="{{ url('recibo-empresa/'.$receipt->receipt_id.'/pdf?vias=2') }}" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-print"></i> 2 Via </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

    <!-- /page content -->

  @include('modals.receipt.create')

   @include('footer')


@endsection

@push('stylesheets')
  <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
@endpush

@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/receipt.min.js')}}"></script>
@endpush

@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">

      <div class="x_panel">
        <div class="x_title">
          <h2>Recibos <small>Recibos emitidos pela empresa</small></h2>
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
                  <th scope="row">{{$receipt->receipt_id}}</th>
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
                    {{ $receipt->receipt_date }}
                  </td>
                  <td style="white-space:nowrap;">
                    <a href="{{ url('recibo-empresa/'.$receipt->receipt_id).'/edit' }}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar </a>
                    <a href="#" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-print"></i> 1 Via </a>
                    <a href="#" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-print"></i> 2 Vias </a>
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

    <!-- footer content -->
    <footer>
        <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

@endsection

@push('stylesheets')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
@endpush

@push('scripts')
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js">
	</script>
<script>
$(document).ready(function() {
  $('#receipts-table').DataTable();
} );
</script>
@endpush

@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
      <form data-parsley-validate class="form-horizontal form-label-left" action="{{url('recibo-empresa')}}" method="POST">

        {{ csrf_field() }}

       <input type="hidden" name="receipt_id_company" value="{{Auth::user()->user_id_company}}">

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Informações <span class="required">*</span>
          </label>
          <div class="col-md-2 col-sm-2 col-xs-12">
            <input name="receipt_value" required placeholder="Valor" class="form-control col-md-7 col-xs-12" type="text">
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
            <input name="receipt_local" required="required" placeholder="Local" class="form-control col-md-7 col-xs-12" type="text">
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
            <input name="receipt_date" required="required" placeholder="Data" class="form-control col-md-7 col-xs-12" type="text">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Recebemos de <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input name="receipt_received_from" required="required" class="form-control col-md-7 col-xs-12" type="text">
          </div>
        </div>

        <div class="form-group">
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Referente a <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="message" name="receipt_reference" required class="form-control" name="message"></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Emitente <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input name="receipt_emitter" required="required" class="form-control col-md-7 col-xs-12" type="text">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">CNPJ <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input name="receipt_document" required="required" class="form-control col-md-7 col-xs-12" type="text">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success pull-right">Salvar</button>
          </div>
        </div>

      </form>
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

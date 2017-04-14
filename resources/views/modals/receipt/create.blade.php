<div id="modal_create_receipt" class="modal fade" aria-hidden=true>
  <div class="modal-dialog modal-lg">

    <!-- Modal -->
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4>Novo Recibo</h4>
      </div>

      <!-- Formulário  -->
      <form data-parsley-validate="" class="form-horizontal form-label-left" action="{{url('recibo-empresa')}}" method="POST">

        <!-- Modal Body -->
        <div class="modal-body">

          {{ csrf_field() }}

          <input type="hidden" name="receipt_id_company" value="{{Auth::user()->user_id_company}}">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Informações <span class="required">*</span>
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input id="receipt_value" name="receipt_value" required placeholder="Valor" class="form-control col-md-7 col-xs-12" type="text">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input name="receipt_local" required placeholder="Local" class="form-control col-md-7 col-xs-12" type="text">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input id="receipt_date" name="receipt_date" required placeholder="Data" class="form-control col-md-7 col-xs-12" type="text">
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
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-danger" value="Salvar">
        </div>

      </form>

    </div>
  </div>
</div>

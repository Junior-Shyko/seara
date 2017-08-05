<div id="modal-receipt-settings" class="modal fade" aria-hidden=true>
  <div class="modal-dialog modal-md">

    <!-- Modal -->
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4>Configurações de Recibo</h4>
      </div>


        <!-- Modal Body -->
        <div class="modal-body">

          <!-- Formulário  -->
          <form id="form-receipt-settings" class="form-horizontal" autocomplete="off" action="javascript:;">

            <input type="hidden" name="setting_id_company" value="{{ $company->company_id }}">

            <!-- Valor, Local e Data -->
            <div class="row">
              <div class="col-md-12">
                <label class="form-label" for="first-name">
                  Informações Básicas
                </label>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <!-- Valor -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name="setting_receipt_local" placeholder="Local"
                  class="form-control" type="text">
                </div>
                <!-- Local -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name="setting_receipt_emitter" placeholder="Emitente"
                  class="form-control" type="text">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <!-- Data -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name="setting_receipt_document" placeholder="Documento"
                  class="form-control" type="text">
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="setting_receipt_email" placeholder="Email/Website" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <label class="form-label">
                  Cabeçalho
                </label>
              </div>
            </div>

            <!-- Recebido de -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea class="form-control" name="setting_receipt_header" rows="5"></textarea>
                </div>
              </div>
            </div>

          </form> <!-- Fim do form -->

        </div> <!-- Fim do modal-body -->

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal" type="button" >Cancelar</button>
          <button class="btn btn-primary" onclick="$('#form-receipt-settings').submit()">Salvar</button>
        </div>

    </div> <!-- Fim Modal content -->
  </div>
</div>

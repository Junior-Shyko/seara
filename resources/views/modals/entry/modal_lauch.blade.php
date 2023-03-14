<div id="modal-entry" class="modal fade" aria-hidden=true>
    <div class="modal-dialog modal-lg">
  
      <!-- Modal -->
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4>LANÇAMENTO NO CAIXA</h4>
          <div class="form-group">
            <div class="col-md-6">
                <label for="" class="label label-primary">MÊS/ANO: DEZEMBRO/2020</label>
            </div>
            <div class="col-md-6">
                <h2 class="label label-primary pull-right" id="balance_actual" style="font-size: 15px;">Saldo Atual</h2>
            </div>
          </div>
        </div>
          <!-- Modal Body -->
          <div class="modal-body">
  
            <!-- Formulário  -->
            <form id="form-receipt" data-parsley-validate="" class="form-horizontal form-label-left" autocomplete="off">
  
              {{ csrf_field() }}
  
               <input type="hidden" id="entries_id_company" name="entries_id_company" value="">
                <div class="col-md-4 col-sm-12  form-group">
                    <label for="">Dia</label>
                    <input type="text" placeholder="Ex: 02" class="form-control">
                </div>
                <div class="col-md-8 col-sm-12  form-group">
                    <label for="">Histórico</label>
                    <input type="text" placeholder="Pgto de aluguel" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12  form-group">
                    <label for="">Dízimo</label>
                    <input type="text" placeholder="R$" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12  form-group">
                    <label for="">Ofertas</label>
                    <input type="text" placeholder="R$" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12  form-group">
                    <label for="">Outras</label>
                    <input type="text" placeholder="R$" class="form-control">
                </div>
            </form> <!-- Fim do form -->
  
          </div> <!-- Fim do modal-body -->
  
          <!-- Modal Footer -->
          <div class="modal-footer">
            <button class="btn btn-default pull-left" data-dismiss="modal" type="button" >Cancelar</button>
            <button id="form-save-btn" class="btn btn-danger">Salvar</button>
          </div>
  
      </div> <!-- Fim Modal content -->
    </div>
  </div>
  
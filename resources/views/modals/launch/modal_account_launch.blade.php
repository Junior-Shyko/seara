<div class="modal fade" id="modalEditAccountLaunch" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Alterar Conta</h4>
        </div>
        <form id="form-edit-account-launch">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">Tipo da conta</label>
                        <select name="accountlaunch_type" id="modalAccountlaunch_type" class="form-control">
                            <option value="">--Selecione--</option>
                            <option value="1">Receitas</option>
                            <option value="2">Despesa</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <label for="">Nome da conta</label>
                    <div class="form-group">
                        <input type="text" name="accountlaunch_name" class="form-control" id="modalAccountlaunch_name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
          <button type="button" class="btn btn-primary" id="edit-form-edit-account-launch">Alterar Conta</button>
          <input type="hidden" name="id" id="modalAccountLaunchId">
        </div>
        </form>
        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
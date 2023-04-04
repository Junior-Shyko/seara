<!-- MODAL DE EXCLUIR PERMISSAO DE USUARIO -->
<div class="modal fade" id="modalDeletePermissionUser" tabindex="-1" role="dialog" aria-labelledby="modalDeletePermissionUser">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="title-h4-modal">Excluir Permissão</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="alert alert-danger" role="alert">
                <p>
                  <label for="" id="body-delete-user-permission">Deseja realmente excluir esse permissao </label>
                </p>
                
              </div>
              <p style="display: flex; justify-content: center; align-items: end;">
                <i class="fa fa-info-circle text-danger fa-2x" aria-hidden="true"></i>
                <label class="text-danger" id="danger-delete-user-permission" style="margin-left: 5px;"></label>
              </p>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="idDeleteUserPermission" id="idDeleteUserPermission">
          <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
          <button type="button" class="btn btn-danger" id="btn-delete-user-permission">Sim, quero excluir</button>
        </div>
      </div>
    </div>
  </div>
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
            <div class="col-md-12">
              <div class="alert alert-danger" role="alert">
                <label for="" id="body-delete-user-permission">Deseja realmente excluir esse permissao </label>
              </div>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="idDeleteUserPermission" id="idDeleteUserPermission">
          <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
          <button type="button" class="btn btn-danger" id="btn-delete-user-permission">Sim, excluir</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade " id="create_account" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Criar Conta</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Nome da conta</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class="form-control" id="accounts_name" name="accounts_name">
                            <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Tipo</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="accounts_id_type_account" id="accounts_id_type_account">
                                <option value="0" selected="">Entrada</option>
                                <option value="1">Saída</option>
                            </select>
                            
                        </div>
                    </div>
                    
                    
                  
                    <div class="form-group">
                        <input type="text" name="accounts_id_user" id="accounts_id_user" value="{{Auth::user()->id}}">
                        <input type="text" name="accounts_id_company" id="accounts_id_company" value="{{Auth::user()->user_id_company}}">
                        
                    </div>
                    <div class="ln_solid"></div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary" id="save_account" >Salvar</button>
            </div>
        </div>
    </div>
</div>

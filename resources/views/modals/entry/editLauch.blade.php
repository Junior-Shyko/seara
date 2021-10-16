<!-- Modal de Edoção de Lançamento-->
<div class="modal fade" id="modalEditLauch" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
                ALTERAR LANÇAMENTO<small>Altere o registro ou os arquivos.</small>
            <div class="clearfix"></div>
            </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-3 col-sm-4 form-group">
                    <label for="">Conta:</label>
                    <select name="entries_id_account" id="cod_account" class="form-control select2">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-4 form-group">
                    <label for="">Tipo de conta:</label> <br>
                    <h4 class="control-label text-primary" id="label_desc_type">
                        <strong>Despesas</strong>
                    </h4>
                </div>
                <div class="col-md-3 col-sm-4 form-group">
                    <label for="">Tipo de conta:</label> <br>
                    <h4 class="control-label text-primary" id="label_desc_type">
                        <strong>Despesas</strong>
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-6 form-group">
                    <label for="">Histórico:</label>
                    <input type="text"  name="entries_description" class="form-control" value="Lorem opsum">
                </div>
                <div class="col-md-4 col-sm-6 form-group">
                    <label for="">Valor:</label>
                    <input type="text" class="form-control" 
                    id="entries_value"
                    name="entries_value" value="100">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            <hr>
        </div>
        <div class="modal-body">          
            <div class="row">
                <div class="col-md-6">
                    <h2>Arquivos <small>Todos os arquivos enviados.</small></h2>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-success pull-right"
                        data-toggle="modal"
                        data-id="1"
                        data-target="#modalUploadLaunch">
                            <i class="fa fa-plus"></i>
                            Adicionar
                        </a>
                    <a href="#"  class="btn btn-info pull-right" title="Atualizar arquivos">
                        <i class="fa fa-refresh"></i>
                    </a>    
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Arquivo</th>
                                <th>Enviado</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
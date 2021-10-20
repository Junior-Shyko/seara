<!-- Modal de Edoção de Lançamento-->
<div class="modal fade" id="modalEditLauch" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
                ALTERAR LANÇAMENTO <small> Altere o registro ou os arquivos.</small>
            <div class="clearfix"></div>
            </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-6 form-group">
                    <label for="">Conta:</label>
                    <select name="entries_id_account" id="cod_account" class="form-control select2">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 form-group">
                    <label for="">Tipo de conta:</label> <br>
                    <h4 class="control-label text-primary" id="labelDescType">
                        <strong>Despesas</strong>
                    </h4>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 form-group">
                    <label for="">Data:</label> <br>
                    <input type='text' name="entries_date_launch" class="form-control date-mask"  id='dateLaunchEdit' value=""/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                    <label for="">Histórico:</label>
                    <input type="text"  name="entries_description" id="entriesDescriptionEdit" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                    <label for="">Valor:</label>
                    <input type="text" class="form-control money-mask" 
                    id="entriesValueEdit"
                    name="entries_value">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-close"></i>
                Sair
            </button>
            <button type="button" class="btn btn-primary">
                <i class="fa fa-save"></i>
                Alterar
            </button>
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            </tr>
                            <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            </tr>
                            <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
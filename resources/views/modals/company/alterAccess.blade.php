 <!-- Modal -->
 <div class="modal fade" id="modalAcessClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                         aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Cadastrar Usuário</h4>
             </div>
             <div class="modal-body">
                 <div class="row">
                    <div class="x_content">
                        <div class="col-md-12" id="divAlterUserAccess">
                            <a class="btn btn-default" title="Altere os dados do usuário" id="btnAlterUserAccess"> Alterar Usuário</a>
                        </div>
                    </div>
                     <div class="x_content">
                         <br>
                         <form id="formAccessUser" data-parsley-validate="" class="form-horizontal form-label-left"
                             novalidate="">
                             <div class="item form-group">
                                 <label class="col-form-label col-md-12 col-sm-12 label-align" for="first-name">Nome
                                     <span class="required">*</span>
                                 </label>
                                 <div class="col-md-12 col-sm-12 ">
                                     <input type="text" id="login_user" name="name" required="required" class="form-control ">
                                 </div>
                             </div>
                             <div class="item form-group">
                                <label class="col-form-label col-md-12 col-sm-12 label-align" for="login_email">E-mail
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-12 col-sm-12 ">
                                    <input type="email" id="login_email" name="email" required="required" class="form-control ">
                                </div>
                            </div>
                             <div class="item form-group">
                                 <label class="col-form-label col-md-12 col-sm-12 label-align" for="password">Senha
                                     <span class="required">*</span>
                                 </label>
                                 <div class="col-md-12 col-sm-12 ">
                                     <input type="password" id="password" name="lpassword" required="required"
                                         class="form-control">
                                 </div>
                             </div>
                             @role('superAdmin')
                             <div class="item form-group">
                                <label class="col-form-label col-md-12 col-sm-12 label-align" for="password">
                                    Nível de acesso
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-12 col-sm-12 ">
                                    <input type="text" name="" value="admin" class="form-control" disabled>
                                    <p class="help-block">Quando o Super Administrador cria um acesso é dado ao novo
                                        usuário um nível de <strong>administrador</strong>
                                    <p>
                                </div>
                             </div>
                             @endrole
                             @role('admin')
                             <div class="btn-group " data-toggle="buttons">
                                <label class="col-form-label col-md-12 col-sm-12 label-align" for="password">
                                    Nível de acesso
                                    <span class="required">*</span>
                                </label>                                
                                <label class="btn btn-primary">
                                  <input type="radio" name="role" id="option2" value="admin" autocomplete="off"> Admin
                                </label>
                                <label class="btn btn-primary active">
                                  <input type="radio" name="role" value="user" id="option3" checked autocomplete="off"> Usuário
                                </label>
                              </div>
                                <p class="help-block col-md-12 col-sm-12">
                                    Obs: Por padrão é marcado <strong>usuário</strong>
                                <p>
                            @endrole
                             <div class="ln_solid"></div>
                             <div class="item form-group">
                                 <div class="col-md-12 col-sm-12 offset-md-3">
                                    <button class="btn btn-default" data-dismiss="modal"  type="button">Sair</button>
                                    <button type="button"  id="btnSaveUser" class="btn btn-success pull-right">
                                        <i class="fa fa-save"></i> 
                                        Salvar
                                    </button>
                                    <input type="hidden" name="codCompany" id="codCompany">
                                 </div>
                             </div>
                             
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

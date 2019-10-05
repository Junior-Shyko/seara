<div id="modal-account" class="modal fade" aria-hidden=true>
    <div class="modal-dialog modal-sm">

        <!-- Modal -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Cadastrar conta</h4>
            </div>


            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="account-id">
                <!-- Formulário  -->
                <form id="form-account" data-parsley-validate="" autocomplete="off" action="javascript:;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <label for="name">Nome</label>
                                <input class="form-control" type="text" id="name" name="name">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label for="type">Tipo</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="checking_acount">Conta corrente</option>
                                    <option value="money">Dinheiro</option>
                                    <option value="investment">Investimentos</option>
                                    <option value="other">Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form> <!-- Fim do form -->

            </div> <!-- Fim do modal-body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button" >Cancelar</button>
                <button id="form-save-btn" class="btn btn-primary">Salvar</button>
            </div>

        </div> <!-- Fim Modal content -->
    </div>
</div>
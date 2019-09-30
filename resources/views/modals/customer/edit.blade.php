
<div id="modal-customer" class="modal fade" aria-hidden=true>
    <div class="modal-dialog modal-lg">

        <!-- Modal -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Atualizar cliente</h4>
            </div>


            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="company-id">
                <!-- Formulário  -->
                <form id="form-customer" data-parsley-validate="" autocomplete="off" action="javascript:;">
                    <div class="form-group">
                        <label for="company_name">Razão social</label>
                        <input type="text" id="company_name" name="company_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="company_fantasy">Nome fantasia</label>
                        <input type="text" id="company_fantasy" name="company_fantasy" class="form-control">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <label for="company_cep">CEP</label>
                                <input id="company_cep" name="company_addr_cep" placeholder="60750-060" data-parsley-full="#company_cep" required class="form-control" type="text">
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <label for="company_street">Rua</label>
                                <input id="company_street" name="company_addr_street" required class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <label for="company_number">Número</label>
                                <input id="company_number" name="company_addr_number" placeholder="Nº" required class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label for="company_complement">Complemento</label>
                                <input id="company_complement" name="company_addr_complement" class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5 col-sm-3 col-xs-12">
                                <label for="company_district">Bairro</label>
                                <input id="company_district" name="company_addr_district" placeholder="Bairro" required class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
                            </div>
                            <div class="col-md-5 col-sm-3 col-xs-12">
                                <label for="company_city">Cidade</label>
                                <input id="company_city" name="company_addr_city" placeholder="Cidade" required class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <label for="company_state">Estado</label>
                                <input id="company_state" name="company_addr_state" placeholder="Estado" required class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label for="company_phone">Telefone</label>
                                <input id="company_phone" name="company_phone" placeholder="Telefone" data-parsley-full="#company_phone" required class="form-control col-md-4 col-xs-12" type="text">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label for="company_mobile">Celular</label>
                                <input id="company_mobile" name="company_mobile" placeholder="Celular" class="form-control col-md-4 col-xs-12" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_manager">Responsável</label>
                        <input type="text" id="company_manager" name="company_manager" class="form-control">
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
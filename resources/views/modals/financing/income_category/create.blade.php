<div id="modal-income-category" class="modal fade" aria-hidden=true>
    <div class="modal-dialog modal-sm">

        <!-- Modal -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Cadastrar categoria de receita</h4>
            </div>


            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="income-category-id">
                <!-- Formulário  -->
                <form id="form-income-category" data-parsley-validate="" autocomplete="off" action="javascript:;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label for="name">Nome</label>
                                <input class="form-control" type="text" id="name" name="name">
                            </div>
                        </div>
                    </div>
                </form> <!-- Fim do form -->

            </div> <!-- Fim do modal-body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button" >Cancelar</button>
                <button id="form-save-income-category-btn" data-cy="submit" class="btn btn-primary">Salvar</button>
            </div>

        </div> <!-- Fim Modal content -->
    </div>
</div>

<div id="modal-pay-receivable" class="modal fade" aria-hidden=true>
    <div class="modal-dialog modal-sm">

        <!-- Modal -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Efetivar conta a receber</h4>
            </div>


            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Formulário  -->
                <form id="form-pay-receivable" data-parsley-validate autocomplete="off" action="javascript:;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label for="payment_date">Data de Pagamento</label>
                                <input type="text" required class="form-control date-mask" name="payment_date" id="payment_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Valor pago</label>
                                <input type="text" required class="form-control money-mask" name="amount">
                            </div>
                        </div>
                    </div>
                </form> <!-- Fim do form -->
            </div> <!-- Fim do modal-body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button" >Cancelar</button>
                <button data-cy="pay-receivable" id="form-pay-receivable-btn" class="btn btn-primary" type="submit" form="form-pay-receivable">Salvar</button>
            </div>

        </div> <!-- Fim Modal content -->
    </div>
</div>

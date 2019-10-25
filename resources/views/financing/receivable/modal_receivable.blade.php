<div id="modal-receivable" class="modal fade" aria-hidden=true>
    <div class="modal-dialog modal-md">

        <!-- Modal -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Cadastrar conta a receber</h4>
            </div>


            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="receivable-id">
                <!-- Formulário  -->
                <form id="form-receivable" data-parsley-validate autocomplete="off" action="javascript:;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="amount">Valor</label>
                                <input type="text" required class="form-control money-mask" name="amount" id="amount">
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="due_date">Vencimento</label>
                                <input type="text" required class="form-control date-mask" name="due_date" id="due_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label for="name">Descrição</label>
                                <input class="form-control" required type="text" id="description" name="description">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="income_category_id">Categoria</label>
                                <select required name="income_category_id" id="income_category_id" class="form-control">
                                    @foreach($incomeCategories as $incomeCategory)
                                        <option value="{{ $incomeCategory->id }}">
                                            {{ $incomeCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="account_id">Conta</label>
                                <select required name="account_id" id="account_id" class="form-control">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">
                                            {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form> <!-- Fim do form -->

            </div> <!-- Fim do modal-body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button" >Cancelar</button>
                <button id="form-save-receivable-btn" data-cy="submit" class="btn btn-primary">Salvar</button>
            </div>

        </div> <!-- Fim Modal content -->
    </div>
</div>

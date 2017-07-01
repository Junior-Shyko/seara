<div class="modal fade bs-example-modal-lg" id="lancar_conta" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">lancar caixa</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row alert alert-info">
                                    <p>
                                        <strong>MÊS / ANO: </strong>{{ \Carbon\Carbon::now()->month . ' / '. \Carbon\Carbon::now()->year }}
                                        <label class="pull-right">Saldo Anterior: R$ {{'0,00'}}</label>
                                    </p>
                                </div>
                                <form class="form-horizontal form-label-left input_mask" id="form_entry">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Conta <small>Digite o código da conta desejada</small></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content bs-example-popovers">
                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                                <div class="col-md-3 form-group">
                                                    <input type="text" name="entries_id_account" class="form-control" id="cod_account" placeholder="Cod. Conta">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="control-label text-primary" id="label_desc_account">Decrição da conta</label>

                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label class="control-label text-primary" id="label_desc_type">Tipo da conta: </label>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider-dashed"></div>
                                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                        <input type="text" name="entries_day"  class="form-control has-feedback-left" id="entries_day" placeholder="Dia">
                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input type="text" name="entries_description" class="form-control" id="entries_description" placeholder="Histórico">
                                        <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                        <small>ENTRADAS</small>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" name="entries_decimate"  class="form-control has-feedback-left" id="entries_decimate" placeholder="Dízimo">
                                        <span class="fa fa-money form-control-feedback left" id="" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" name="entries_offer" class="form-control has-feedback-left" id="box_offer" placeholder="Oferta">
                                        <span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" name="entries_other"  class="form-control has-feedback-left" id="entries_other" placeholder="Outras">
                                        <span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                        <small>SAÍDA</small>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" name="entries_end"  class="form-control" id="entries_end" placeholder="Saída">
                                        <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                                <button type="button" class="btn btn-primary" id="save_entry">Salvar Lançamento <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
<div class="modal fade " id="modal_open_box" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Abrir Caixa</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Data Abertura</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class="form-control" id="accounts_name" name="accounts_name">
                            <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Data Abertura</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            {{Form::select('accounts_id_type_account', $type_account, 'Selecione', ['class' => 'form-control' , 'id' => 'accounts_id_type_account'])}}
                        </div>
                    </div>         --}}           
                    
                  
                    <div class="form-group">
                        <input type="hidden" name="accounts_id_user" id="accounts_id_user" value="{{Auth::user()->id}}">
                        <input type="hidden" name="accounts_id_company" id="accounts_id_company" value="{{Auth::user()->user_id_company}}">
                        
                    </div>
                    <div class="ln_solid"></div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary" id="open_box_save" >Abrir Caixa</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade " id="modal_open_box" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Abrir Caixa</h4>
            </div>
            <div class="modal-body">
                

                {{Form::open(['url' => '/abrir-caixa'], ['id' => '' , 'class' => 'form-horizontal form-label-left'])}}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Data Abertura</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class="form-control" id="date_box_open" name="date_box_open">
                            <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>
                @php

                    $getBox = \App\FunctionGeneral::getBox();
                
                @endphp    
                @if(count($getBox) == 0)
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Saldo Inicial</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class="form-control" id="boxies_balance_initial_modal" required="true" name="boxies_balance_initial_modal">
                            <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>
                @endif
                  
                    <div class="form-group">
                        <input type="hidden" name="boxies_id_users" id="boxies_id_users" value="{{Auth::user()->id}}">
                        <input type="hidden" name="boxies_id_company" id="boxies_id_company" value="{{Auth::user()->user_id_company}}">
                    </div>
                    <div class="ln_solid"></div>
                    
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="submit" class="btn btn-primary" id="open_box_save" >Abrir Caixa</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>



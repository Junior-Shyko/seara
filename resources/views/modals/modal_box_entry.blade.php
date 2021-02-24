<link href="{{ url("css/entry.min.css") }}" rel="stylesheet">
<style>
    .dropzone .dz-message {
    text-align: center;
    margin: 2em 0;
    font-size: 20px !important;
    color: #4e65dc !important;
    background: #e5e5ea !important;
    padding: 10px !important;
    border-radius: 8px !important;
    }
    .container{
    margin-top:20px;
    }
    .image-preview-input {
    position: relative;
    overflow: hidden;
    margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
    }
    .image-preview-input input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
    }
    .image-preview-input-title {
    margin-left:2px;
    }
</style>
<div class="modal fade bs-example-modal-lg" id="lancar_conta" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Lançamento no Caixa</h4>
            </div>
            <div class="modal-body">
                <div class="row alert alert-info">
                    <p>
                        <strong>MÊS / ANO: </strong>{{ \Carbon\Carbon::now()->month . ' / '. \Carbon\Carbon::now()->year }}
                        <label class="pull-right">Saldo Anterior: R$ {{number_format($totalPreviusPositive,2,",",".")}}</label>
                    </p>
                </div>
                <form class="form-horizontal form-label-left input_mask" id="form_entry">
                    {{ csrf_field() }}
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Caixa <small>Movimentação do caixa</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content bs-example-popovers">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">Conta </label><small style="color:#949494;    margin-left: 40px;"> Pesquise pelo nome</small>  
                                    <select name="entries_id_account" id="cod_account" class="form-control select2">
                                        @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">
                                            {{ $account->accountlaunch_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 form-group">
                                    <label class="control-label">Tipo da conta: </label>
                                    <br>
                                    <label class="control-label text-primary" id="label_desc_type">. . .</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 form-group">
                                    <label class="control-label">Referente a:</label> <br>
                                    <label class="control-label text-primary" id="account_launches_referring">...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        {{Form::selectRange('entries_day', 01, 31, date('d'), ['class' =>'form-control has-feedback-left' , 'id' => 'entries_day'])}}
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" name="entries_description" class="form-control" id="entries_description" placeholder="Histórico">
                        <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" id="divEntradas">
                        <small>VALOR</small>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" id="diventries_value">
                        <input type="text" name="entries_value"  class="form-control has-feedback-left" id="entries_value" placeholder="Qual o valor?">
                        <span class="fa fa-money form-control-feedback left" id="" aria-hidden="true"></span>
                    </div>
                    
                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                       <input type="text" name="entries_id_company" id="entries_id_company" value="{{Auth::user()->user_id_company}}">
                       <input type="text" name="entries_id_user" id="entries_id_user" value="{{Auth::user()->id}}">
                    </div>
                     <!-- 
                    <div class="col-xs-12 col-md-12 col-sm-8">
                        <div class="form-group">
                            <label>Anexar Recibo</label>
                        </div>
                       image-preview-filename input [CUT FROM HERE]
                        <div class="input-group image-preview">
                            <input type="text" class="form-control image-preview-filename" disabled="disabled"> 
                            <span class="input-group-btn">
                               
                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                <span class="glyphicon glyphicon-remove"></span> Limpar
                                </button>
                               
                                <div class="btn btn-default image-preview-input">
                                    <span class="glyphicon glyphicon-folder-open"></span>
                                    <span class="image-preview-input-title">Procurar</span>
                                    <input type="file" multiple="multiple" accept="image/png, image/jpeg, image/gif" name="file[]"/>
                                </div>
                            </span>
                        </div>
                         
                    </div>-->
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary" id="save_entry">Salvar Lançamento <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>
        </form>
        </div>
    </div>
</div>
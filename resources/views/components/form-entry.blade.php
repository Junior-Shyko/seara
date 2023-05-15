<div class="x_panel">
    <div class="x_title  title-entry-modal">
        <h2 class="badge {{$badge_title}}">
           {{ $title }}
        </h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content bs-example-popovers">
        {{ $option_bank }}

        <div  id="form-launch-register" class="">
            <div class="col-md-12 col-sm-12 col-xs-12 jumbotron-lauch" id="jumbotron-lauch">

                <div class="col-md-12 form-inline center-info-data-bank" id="center-info-data-bank"></div>

                <div class="col-md-12 form-group">
                    <label class="control-label">Conta </label>
                    <small style="color:#949494; margin-left: 40px;"> Pesquise pelo nome</small>
                    <select name="entries_id_account" 
                        class="form-control select2 {{$saveBtnForm}}"
                        data-form="{{$saveBtnForm}}"
                    >
                            <option value=""></option>
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
                    <label 
                    class="control-label text-primary mb-20 label_desc_type_internal label_desc_type"
                    
                    style="font-size: 17px;font-family: cursive;"
                    >. . .</label>
                </div>

                <div class="col-md-4 col-sm-3 col-xs-12 form-group" id="divRectroativeLaunch" >
                    <label for="">Data</label>
                    <div class='input-group date'>
                        <input type='text' name="entries_date_launch" class="form-control date-mask"  id='dateRetroactive' value="{{date('d/m/Y')}}"/>
                    </div>
                </div>
                <div class="col-md-4 col-sm-9 col-xs-12 form-group  has-feedback">
                    <label for="">Valor</label>
                    <div class="form-group" id="diventries_value">
                        <div class="input-group date">
                            <input type="text" class="form-control has-feedback-left money-mask"  name="entries_value" id="entries_value_money-mask" >
                            <span class="fa fa-money form-control-feedback left"></span>
                        </div>
                    </div>
                    
                </div>

                <div class="col-md-12 form-group has-feedback">
                    <label for="">Histórico</label>
                    <input type="text" 
                    name="entries_description"
                    class="form-control has-feedback-left mb-20 entries_description"
                    id="entries_description"
                    placeholder="Histórico">
                    <span class="fa fa-edit form-control-feedback left" aria-hidden="true"></span>
                </div>
                
                
                <div class="col-md-12 form-group">
                    <button 
                        type="button"
                        class="btn btn-default btn-xs btn-block badge-dark"
                        onclick="clearField('{{$saveBtnForm}}')"
                    >
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                        Limpar campos
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 col-sm-12 offset-md-3">
        <input type="hidden" id="typeTransactionForm" class="typeTransactionForm">
        <input type="hidden" id="entries_id_user" name="entries_id_user" value="{{ Auth::user()->id}}" class="entries_id_user">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary pull-right" onclick="saveDataForm('{{$saveBtnForm}}')">Salvar Lançamento 
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
        </button>
    </div>
</div>

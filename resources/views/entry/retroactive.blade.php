<form class="form-horizontal form-label-left input_mask" id="form_entry">
    {{ csrf_field() }}
    <div class="x_panel">
        <div class="x_title">
            <h2>Caixa 
                <small>Movimentação do caixa</small>
            </h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content bs-example-popovers">
            {{$type}}
        	<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                <div class="col-md-4 form-group">
                    <label class="control-label">Conta </label>
                    <small style="color:#949494;    margin-left: 40px;"> Pesquise pelo nome</small>
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
                    <label class="control-label">Referente a:</label>
                    <br>
                    <label class="control-label text-primary" id="account_launches_referring">...</label>
                </div>
            </div>
            @if($type == 'actual')
            	<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                {{Form::selectRange('entries_day', 01, 31, date('d'), ['class' =>'form-control has-feedback-left' , 'id' => 'entries_day'])}}
                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
            </div>
            @else
            	<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
<div class='input-group date' id='myDatepicker2'>
<input type='text' class="form-control" />
<span class="input-group-addon">
<span class="fa fa-calendar form-control-feedback left"></span>
</span>
</div>
</div>
            @endif
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
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 offset-md-3">
            <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
            <button type="button" class="btn btn-primary pull-right" id="save_entry">Salvar Lançamento 
            <i class="fa fa-floppy-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</form>
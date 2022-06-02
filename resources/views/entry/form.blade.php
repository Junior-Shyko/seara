<form class="form-horizontal form-label-left input_mask" id="form_entry">
    {{ csrf_field() }}
    <div class="x_panel">
        <div class="x_title">
            <h2>Caixa 
                <small>Movimentação do caixa </small>
            </h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content bs-example-popovers">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                <div class="col-md-4 form-group">
                    <label class="control-label">Conta </label>
                    <small style="color:#949494;    margin-left: 40px;"> Pesquise pelo nome</small>
                    <select name="entries_id_account" id="cod_account" class="form-control select2">
                        <option value=""></option>
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}">
                            {{ $account->accountlaunch_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 col-sm-6 col-xs-6 form-group">
                    <label class="control-label">Tipo da conta: </label>
                    <br>
                    <label class="control-label text-primary" id="label_desc_type">. . .</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback" id="divRectroativeLaunch" >
                        <label for="">Data</label>
                        <div class='input-group date'>
                            <input type='text' name="entries_date_launch" class="form-control date-mask"  id='dateRetroactive' value="{{date('d/m/Y')}}"/>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <label for="">Histórico</label>
                        <input type="text" name="entries_description" class="form-control" id="entries_description" placeholder="Histórico">
                        <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
           <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-4">
                    <label for="">Valor</label>
                    <div class="form-group" id="diventries_value">
                        <div class="input-group date">
                            <input type="text" class="form-control has-feedback-left money-mask"  name="entries_value" id="entries_value_money-mask" >
                            <span class="fa fa-money form-control-feedback left"></span>
                        </div>
                    </div>
                </div>
                
                {{-- <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback" >
                    <label>Caixa</label>
                    <p>
                        <label class="btn btn-primary flat">
                            <input type="radio" name="entries_bank" value="1"> Banco
                        </label>
                        <label class="btn btn-primary flat">
                            <input type="radio" checked name="entries_bank" value="0"> Interno
                        </label>
                    </p>
                </div> --}}
            </div>
           </div>
            <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                <input type="text" name="entries_id_company" id="entries_id_company" value="{{$idCompany}}">
                <input type="hidden" name="entries_id_user" id="entries_id_user" value="{{Auth::user()->id}}">
                <input type="hidden" name="type" id="typeLaunch" value="actual">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 offset-md-3">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary pull-right" id="save_entry">Salvar Lançamento 
            <i class="fa fa-floppy-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</form>
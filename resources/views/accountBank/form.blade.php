

<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <label for="">Banco</label>
        <select name="bank_id" id="bank_id" class="form-control select2">
            <option value="">--selecione--</option>
            @foreach($banks as $bank)
            <option value="{{ $bank->id }}">
                {{ $bank->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12  form-group">
        <label for="">Tipo de conta bancaria</label>
        <select name="typeBank_id" id="selectTypeAccountBank" class="form-control select2">
            <option value="">--selecione--</option>
            @foreach($types as $type)
            <option value="{{ $type->id }}">
                {{ $type->text }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12  form-group">
        <label for="">Valor</label>
        <input type="text" id="valueAccontBank" name="balance" placeholder="R$ 0,00" class="form-control" value="0.00">
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <label for="">Número da conta</label>
        <input type="text" name="number" id="accountBankNumber" placeholder="xx-y" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <label for="">Número da agência</label>
        <input type="text" name="agency_number" placeholder="xx-y" id="agency_number"  class="form-control">
    </div>
</div>
<div class="row">
    <div class="modal-footer">
        <input type="text" name="company_id" id="company_id" 
        value="{{Auth::user()->user_id_company}}">
        <input type="text" name="owner" id="owner_id" 
        value="{{Auth::user()->id}}">
        <input type="text" name="idAccontBank" id="idAccontBank" value="">
        <a class="btn btn-primary" id="btnSaveAccontBank" title="Cadastrar conta bancaria">
            <i class="fa fa-save"></i> Salvar
        </a>
    </div>
</div>

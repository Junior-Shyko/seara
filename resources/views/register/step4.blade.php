<div id="step-4" class="content" style="display: none;">

  <form id="form-step-4" class="form-horizontal form-label-left">
    <!-- Dados Pessoais -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Dados Pessoais <span class="required">*</span>
      </label>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="user_cpf" name="user_cpf" data-parsley-full="#user_cpf" placeholder="CPF" data-parsley-seara="cpf" required class="form-control col-md-2 col-xs-12" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="user_birth" name="user_birth" placeholder="Data de Nascimento" data-parsley-full="#user_birth" data-parsley-seara="data" required class="form-control col-md-2 col-xs-12" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="user_phone" name="user_phone" placeholder="Telefone de Contato" data-parsley-full="#user_phone" required class="form-control col-md-2 col-xs-12" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <div id="gender" class="btn-group" data-toggle="buttons">
          <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
            <input name="gender" value="Masculino" data-parsley-multiple="gender" type="radio">
            &nbsp; Masculino &nbsp;
          </label>
          <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
            <input name="gender" value="Feminino" data-parsley-multiple="gender" type="radio" checked> Feminino
          </label>
        </div>
      </div>
    </div>

    <!-- Endereço: Parte 1 -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="street">Endereço <span class="required">*</span>
      </label>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="user_cep" name="user_addr_cep" placeholder="CEP" data-parsley-full="#user_cep" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="user_street" name="user_addr_street" placeholder="Rua" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
        <input id="user_number" name="user_addr_number" placeholder="Nº" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="user_complement" name="user_addr_complement" placeholder="Complemento" class="form-control col-md-7 col-xs-12" type="text">
      </div>
    </div>

    <!-- Endereço Parte 2 -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="user_district" name="user_addr_district" placeholder="Bairro" required class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="user_city" name="user_addr_city" placeholder="Cidade" required class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="user_state" name="user_addr_state" placeholder="Estado" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
    </div>

    <!-- Cargo -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="street">Cargo <span class="required">*</span>
      </label>
      <div class="col-md-4 col-sm-4 col-xs-12">
        <input id="user_position" name="user_position"   required class="form-control col-md-6 col-xs-12" type="text">
      </div>
    </div>
  </form>
</div>

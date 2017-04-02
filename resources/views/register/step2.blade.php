<div id="step-2" class="content" style="display: none;">
  <form id="form-step-2" method="post" action="/companies" class="form-horizontal form-label-left">
     {{ csrf_field() }}
     <input type="hidden" name="company_cnpj" value="">

     <!-- Razão Social -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Razão Social <span class="required">*</span>
      </label>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <input id="company_name" name="company_name" placeholder="Razão Social" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
    </div>

    <!-- Nome Fantasia -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fantasy">Nome Fantasia <span class="required">*</span>
      </label>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <input id="company_fantasy" name="company_fantasy" placeholder="Nome Fantasia" required class="form-control col-md-8 col-xs-12" type="text">
      </div>
    </div>

    <!-- Endereço: Parte 1 -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="street">Endereço <span class="required">*</span>
      </label>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="company_cep" name="company_cep" placeholder="CEP" data-parsley-full="#company_cep" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="company_street" name="company_street" placeholder="Rua" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
        <input id="company_number" name="company_number" placeholder="Nº" required class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="company_complement" name="company_complement" placeholder="Complemento" class="form-control col-md-7 col-xs-12" type="text">
      </div>
    </div>

    <!-- Endereço Parte 2 -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="company_district" name="company_district" placeholder="Bairro" required class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="company_city" name="company_city" placeholder="Cidade" required class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
      </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <input id="company_state" name="company_state" placeholder="Estado" required class="form-control col-md-7 col-xs-12" type="text">
    </div>
    </div>

    <!-- Telefones de Contato -->
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fantasy">Telefone/Celular <span class="required">*</span>
      </label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="company_phone" name="company_phone" placeholder="Telefone" data-parsley-full="#company_phone" required class="form-control col-md-4 col-xs-12" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="company_mobile" name="company_mobile" placeholder="Celular" data-parsley-full="#company_mobile" required class="form-control col-md-4 col-xs-12" type="text">
      </div>
    </div>
  </form>
</div>

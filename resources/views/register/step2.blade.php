<div id="step-2" class="content" style="display: none;">
  <form id="empresa" method="post" action="/companies" class="form-horizontal form-label-left">
     {{ csrf_field() }}

     <input type="hidden" name="company_cnpj" value="">
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Razão Social <span class="required">*</span>
      </label>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <input id="name" name="company_name" required="required" class="form-control col-md-7 col-xs-12" type="text">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fantasy">Nome Fantasia <span class="required">*</span>
      </label>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <input id="fantasy" name="company_fantasy" required="required" class="form-control col-md-8 col-xs-12" type="text">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="street">Endereço <span class="required">*</span>
      </label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="street" name="company_street" class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
        <input id="number" name="company_number" class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="district" name="company_district" class="form-control col-md-7 col-xs-12" type="text">
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="cep" name="company_cep" class="form-control col-md-7 col-xs-12" type="text">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="city" name="company_city" class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="state" name="company_state" class="form-control col-md-7 col-xs-12" name="middle-name" type="text">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fantasy">Telefone/Celular <span class="required">*</span>
      </label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="phone" name="company_phone" class="form-control col-md-4 col-xs-12" type="text">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="mobile" name="company_mobile" class="form-control col-md-4 col-xs-12" type="text">
      </div>
    </div>
  </form>
</div>

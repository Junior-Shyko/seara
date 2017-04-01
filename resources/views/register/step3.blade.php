<div id="step-3" class="content" style="display: none;">
  <form id="form-step-3" class="form-horizontal form-label-left">

    <!-- Nome Completo -->
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome Completo <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="user_name" name="name" required class="form-control col-md-6 col-xs-12" type="text">
      </div>
    </div>

    <!-- Email -->
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fantasy">Email <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="user_email" name="email" placeholder="name@example.com" required data-parsley-type="email"
          class="form-control col-md-6 col-xs-12" type="text">
      </div>
    </div>

    <!-- Senha -->
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="street">Senha <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="user_password" name="password" required class="form-control col-md-6 col-xs-12" type="password">
      </div>
    </div>

    <!-- Confirmação de Senha -->
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="street">Confirme sua senha <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="user_confirm_password" data-parsley-equalto="#user_password" required class="form-control col-md-6 col-xs-12" type="password">
      </div>
    </div>

  </form>
  <p><strong>Observação: </strong>Este é o cadastro do responsável pela empresa. Este usuário terá acesso
  administrativo ao sistema. Operadores devem ser cadastrados pelo responsável posteriormente.</p>
</div>

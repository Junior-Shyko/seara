<div id="wizard" class="form_wizard wizard_horizontal">
  <ul class="wizard_steps anchor">
    <li>
      <a href="#step-1" class="selected" isdone="1" rel="1">
        <span class="step_no">1</span>
        <span class="step_descr">
          Passo 1<br>
          <small>CNPJ da Empresa</small>
        </span>
      </a>
    </li>
    <li>
      <a href="#step-2" class="disabled" isdone="0" rel="2">
        <span class="step_no">2</span>
        <span class="step_descr">
          Passo 2<br>
          <small>Cadastro da Empresa</small>
        </span>
      </a>
    </li>
    <li>
      <a href="#step-3" class="disabled" isdone="0" rel="3">
        <span class="step_no">3</span>
        <span class="step_descr">
          Passo 3<br>
          <small>Cadastro do Responsável</small>
        </span>
      </a>
    </li>
    <li>
      <a href="#step-4" class="disabled" isdone="0" rel="4">
        <span class="step_no">4</span>
        <span class="step_descr">
          Passo 4<br>
          <small>Informações Adicionais</small>
        </span>
      </a>
    </li>
  </ul>

  <!-- <div class="stepContainer" style="height: 282px;"> -->

    @include('register.step1')
    @include('register.step2')
    @include('register.step3')
    @include('register.step4')
  <!-- </div> -->
</div>

  <!-- <script src="gentelella/vendors/parsleyjs/dist/parsley.min.js"></script> -->
  <script>
  $(document).ready(function(){
      Inputmask().mask(document.querySelectorAll("input")); // chama a máscara
      $("#cnpj").inputmask("99.999.999/9999-99"); //specifying options
      $("#cpf").inputmask("999.999.999-99"); //specifying options
      $("#user_phone").inputmask("(99)9-9999-9999"); //specifying options
      $("#birth").inputmask("99/99/9999"); //specifying options
      $("#cep").inputmask("99.999-999")
      $("#user_cep").inputmask("99.999-999")

    // Smart Wizard
    $('#wizard').smartWizard({
      onLeaveStep:leaveAStepCallback,
      onFinish:onFinishCallback,
      onShowStep: onShow,
      labelNext: "Avançar",
      labelFinish: "Concluir",
      labelPrevious: "Voltar"
    });

    function leaveAStepCallback(obj, context){
      return validateSteps(context.fromStep); // return false to stay on step and true to continue navigation
    }

    function onFinishCallback(objs, context){
      if(validateAllSteps()){
        $('form').submit();
      }
    }

    function onShow(obj, context)
    {
      var size = $("#step-" + context.toStep).height() + 20;
      $(".stepContainer").css('height', size);
    }

    // Your Step validation logic
    function validateSteps(stepnumber){
      var url = 'http://receitaws.com.br/v1/cnpj/22002899000114'
      // validate step 1
      if(stepnumber == 1){
        $.ajax({
          url: url,
          dataType: 'jsonp',
          jsonp: 'callback',
          async: false,
          success: function(data){
            $("#name").val(data.nome);
            $("#fantasy").val(data.fantasia);
            $("#street").val(data.logradouro);
            $("#number").val(data.numero + " " + data.complemento);
            $("#cep").val(data.cep);
            $("#district").val(data.bairro);
            $("#city").val(data.municipio);
            $("#state").val(data.uf);
            $("#phone").val(data.telefone);
          },
          error: function(){
          }
        });
      }
        return true;

    }

    function validateAllSteps(){
      var isStepValid = true;
      // all step validation logic
      return isStepValid;
    }
  });
  </script>

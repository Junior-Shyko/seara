<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Gentellela Alela! | </title>

  <!-- Bootstrap -->
  <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset("css/font-awesome.min.css") }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">

  <link href="gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="gentelella/build/css/custom.min.css" rel="stylesheet">
  <!-- <link href="gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> -->

  <!-- jQuery -->
  <script src="gentelella/vendors/jquery/dist/jquery.min.js"></script>

</head>

<body class="login">
<div class="login_wrapper" style="max-width: 1000px;">
  <div class="animate form login_form">
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
  </div>
</div>



<script>
$(document).ready(function(){
  Inputmask().mask(document.querySelectorAll("input")); // chama a máscara
  $("#cnpj").inputmask("99.999.999/9999-99"); //specifying options
  $("#cpf").inputmask("999.999.999-99"); //specifying options
  $("#user_phone").inputmask("(99)99999-9999"); //specifying options
  $("#birth").inputmask("99/99/9999"); //specifying options
  $("#cep").inputmask("99.999-999");
  $("#user_cep").inputmask("99.999-999",{
    "oncomplete": function(){ // Ao concluir o CEP, vou fazer uma requisição e preencer automaticamente
      $.ajax({
        url: "http://correiosapi.apphb.com/cep/"+$("#user_cep").inputmask("unmaskedvalue"),
        dataType: 'jsonp',
        jsonp: 'callback',
        async: false,
        success: function(data){
          $("#user_street").val(data.tipoDeLogradouro + " " + data.logradouro);
          $("#user_city").val(data.cidade);
          $("#user_state").val(data.estado);
          $("#user_district").val(data.bairro);
        },
        error: function(){
        }
      });
    }
  });

  // Smart Wizard
  $("#wizard").smartWizard({
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
    console.log("Acabou");
    var data = {};
    $("#usuario1").serializeArray().map(function(x){
      data[x.name] = x.value;
    });

    $("#usuario2").serializeArray().map(function(x){
      data[x.name] = x.value;
    });

    data['user_id_profile'] = 1;
    data['user_id_company'] = 2;

    $.post('/users', data);
  }

  function onShow(obj, context)
  {
    var size = $("#step-" + context.toStep).height() + 20;
    $(".stepContainer").css('height', size);
  }

  // Your Step validation logic
  function validateSteps(stepnumber){
    var url = 'http://receitaws.com.br/v1/cnpj/'+$("#cnpj").inputmask("unmaskedvalue");
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
    } else if (stepnumber == 2) {
      $("#empresa input[name=company_cnpj]").val($("#cnpj").val());
      var testando = $("#empresa").serializeArray();
      var data = {};
       $("#empresa").serializeArray().map(function(x){
         data[x.name] = x.value;
      });

      $.post("/companies", data, function(data){
        console.log(data);
      });
      // $("#empresa").submit();
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

<!-- <script src="gentelella/vendors/parsleyjs/dist/parsley.min.js"></script> -->


<!-- jQuery -->
<!-- <script src="{{ asset("js/jquery.min.js") }}"></script> -->
<!-- Bootstrap -->
<!-- <script src="{{ asset("js/bootstrap.min.js") }}"></script> -->
<!-- Custom Theme Scripts -->
<!-- <script src="{{ asset("js/gentelella.min.js") }}"></script> -->


<!-- Bootstrap -->
<script src="gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="{{asset("gentelella/vendors/fastclick/lib/fastclick.js")}}"></script>
<!-- NProgress -->
<script src="gentelella/vendors/nprogress/nprogress.js"></script>
<!-- jQuery Smart Wizard -->
<script src="{{asset("gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js")}}"></script>
<!-- Custom Theme Scripts -->
<script src="gentelella/build/js/custom.min.js"></script>
<!-- Input Mask -->
<script src="gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<!-- Date Range Picker -->
<!-- <script src="gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script> -->

</body>
</html>

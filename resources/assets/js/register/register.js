function reconfigureWizardView(stepNumber)
{
  var current_height = $("#step-" + stepNumber).height();
  $(".stepContainer").css('height', current_height + 20);
}

function requestCnpj()
{
  var url = 'http://receitaws.com.br/v1/cnpj/'+$("#company_cnpj").inputmask("unmaskedvalue");
  $.ajax({
    url: url,
    dataType: 'jsonp',
    jsonp: 'callback',
    async: false,
    success: function(data){
      $("#company_name").val(data.nome);
      $("#company_fantasy").val(data.fantasia);
      $("#company_street").val(data.logradouro);
      $("#company_number").val(data.numero + " " + data.complemento);
      $("#company_complement").val(data.complemento);
      $("#company_cep").val(data.cep);
      $("#company_district").val(data.bairro);
      $("#company_city").val(data.municipio);
      $("#company_state").val(data.uf);
      $("#company_phone").val(data.telefone);
    },
    error: function(){
    }
  });
}

function initMask()
{
  Inputmask().mask(document.querySelectorAll("input")); // chama a máscara

  /* MÁSCARA PARA FORMULÁRIO DE EMPRESAS */
  $("#company_cnpj").inputmask("99.999.999/9999-99", {
    "oncomplete": function() { $('#form-step-1').parsley().validate(); }
  }); //specifying options
  $("#company_cep").inputmask("99.999-999");
  $("#company_phone").inputmask("(99)9999-9999");
  $("#company_mobile").inputmask("(99)99999-9999");

  /* MÁSCARA PARA FORMULÁRIO DE USUÁRIOS */
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
}

$(document).ready(function(){
  initValidator();
  initMask();

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
    // var data = {};
    // $("#usuario1").serializeArray().map(function(x){
    //   data[x.name] = x.value;
    // });
    //
    // $("#usuario2").serializeArray().map(function(x){
    //   data[x.name] = x.value;
    // });
    //
    // data['user_id_profile'] = 1;
    // data['user_id_company'] = 2;
    //
    // $.post('/users', data);
  }

  function onShow(obj, context)
  {
    reconfigureWizardView(context.toStep);
  }

  // Your Step validation logic
  function validateSteps(stepnumber){
    var isValid = false;

    // Vamos validar o step 1
    if(stepnumber == 1){

      // Executa validador
      $('#form-step-1').parsley().validate();
      isValid = $('#form-step-1').parsley().isValid(); // Verifica se campo é válido
      if(isValid) requestCnpj(); // Faz requisição no ReceitaWS somente caso seja válido

    } else if (stepnumber == 2) {
      // $("#empresa input[name=company_cnpj]").val($("#cnpj").val());
      // var testando = $("#empresa").serializeArray();
      // var data = {};
      // $("#empresa").serializeArray().map(function(x){
      //   data[x.name] = x.value;
      // });
      //
      // $.post("/companies", data, function(data){
      //   console.log(data);
      // });
      // $("#empresa").submit();

      $('#form-step-2').parsley().validate();
      isValid = $('#form-step-2').parsley().isValid();

    } else if (stepnumber == 3) {

      $('#form-step-3').parsley().validate();
      isValid = $('#form-step-3').parsley().isValid();

    } else if (stepnumber == 4) {

    }
    return isValid;
  }

  function validateAllSteps(){
    var isStepValid = true;
    // all step validation logic
    return isStepValid;
  }

  $('.buttonNext').addClass('btn btn-success');
  $('.buttonPrevious').addClass('btn btn-primary');
  $('.buttonFinish').addClass('btn btn-default');

});

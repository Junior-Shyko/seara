function setValidatorMessage(msg)
{
  window.Parsley.addMessage('en', 'seara', msg);
}

function validarCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;

    return true;

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

function searaValidator(value, requirement)
{
  var isValid = false;

  switch(requirement)
  {
    case "cnpj":
    if($("#company_cnpj").inputmask('isComplete')) {
      var cnpj = $("#company_cnpj").inputmask('unmaskedvalue');
      if (validarCNPJ(cnpj)) {
        isValid = true;
      }
      else {
        setValidatorMessage('CNPJ Inválido');
        isValid = false;
      }
    }
    else {
      isValid = false;
    }
    break;
  }

  return isValid;
}

function initValidator()
{
  window.Parsley
  .addValidator('seara', {
    requirementType: 'string',
    validateString: searaValidator,
    messages: {
      en: 'Campo Obrigatório'
    }
  });

  window.Parsley.addMessage('en', 'required', 'Campo Obrigatório');
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
    var size = $("#step-" + context.toStep).height() + 20;
    $(".stepContainer").css('height', size);
  }

  // Your Step validation logic
  function validateSteps(stepnumber){
    var isValid = false;

    // Vamos validar o step 1
    if(stepnumber == 1){

      // Executa validador
		  $('#form-step-1').parsley().validate();
      isValid = $('#form-step-1').parsley().isValid(); // Verifica se campo é válido
      requestCnpj(); // Faz requisição no ReceitaWS

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

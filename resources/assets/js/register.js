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

  $('.buttonNext').addClass('btn btn-success');
  $('.buttonPrevious').addClass('btn btn-primary');
  $('.buttonFinish').addClass('btn btn-default');
});

/*CONFIGURAÇÕES DO WIZARD*/
function initWizard()
{
  // Smart Wizard
  $("#wizard").smartWizard({
    keyNavigation: false,
    onLeaveStep:stepChanged, // validação
    onFinish:formSubmit, // envio para o banco e validação global
    onShowStep: updateWizard, // atualização de view
    labelNext: "Avançar",
    labelFinish: "Concluir",
    labelPrevious: "Voltar"
  });

  $('.buttonNext').addClass('btn btn-success');
  $('.buttonPrevious').addClass('btn btn-primary');
  $('.buttonFinish').addClass('btn btn-default');
}

function stepChanged(obj, context)
{
  var stepNumber = context.fromStep;
  var isValid = false;

  if(stepNumber == 1){
    isValid = validateStep(1);
    if(isValid) requestCnpj(); // Faz requisição no ReceitaWS somente caso seja válido
  } else if (stepNumber == 2) {
    isValid = validateStep(2);
  } else if (stepNumber == 3) {
    isValid = validateStep(3);
  } else if (stepNumber == 4) {
    isValid = validateStep(4);
  }

  return isValid;
}

function formSubmit(objs, context)
{
  // Validação de todos os passos
  if ( !validateStep(1) ) {
    return;
  } else if (!validateStep(2)) {
    return;
  }else if (!validateStep(3)) {
    return;
  }else if (!validateStep(4)) {
    return;
  }else { // todos os passos são válidos
    alert('Agora posso jogar para o servidor');
    store(); // cadastro da empresa e usuário
  }
}

function updateWizard(obj, context)
{
  reconfigureWizardView(context.toStep);
}

function reconfigureWizardView(stepNumber)
{
  var current_height = $("#step-" + stepNumber).height();
  $(".stepContainer").css('height', current_height + 20);
}

function validateStep(stepNumber) {
  $('#form-step-'+stepNumber).parsley().validate();
  return $('#form-step-'+stepNumber).parsley().isValid();
}

/*ENVIO PARA O BANCO DE DADOS*/
function unmask(str)
{
  console.log('str:' + str);
  return str.replace(/[^\d]/g,'');
}

function brDatetoUsa(datestring)
{
  var dateSplitted = datestring.split('/');
  return dateSplitted[2] + '-' + dateSplitted[1] + '-' + dateSplitted[0];
}

function store()
{
  // atribuo o cnpj
  $("#form-step-2 input[name=company_cnpj]").val($("#company_cnpj").val());
  var company = {};
  $("#form-step-2").serializeArray().map(function(x){
    console.log(x.name + ':' + x.value);
    company[x.name] = x.value;
  });

  console.log('retirando máscaras da empresa');
  company['company_cnpj'] = unmask(company['company_cnpj']);
  company['company_addr_cep'] = unmask(company['company_addr_cep']);
  company['company_phone'] = unmask(company['company_phone']);
  company['company_mobile'] = unmask(company['company_mobile']);

  $.post("/companies", company, function(companyResponse){
    // a requisição deu certo, agora vou guardar o usuário
    var user = {};
    $("#form-step-4").serializeArray().map(function(x){
      user[x.name] = x.value;
    });

    $("#form-step-3").serializeArray().map(function(x){
      user[x.name] = x.value;
    });

    user['user_sex'] = $("#form-step-4 input[type='radio']:checked").val();
    user['user_id_profile'] = 1;
    user['user_id_company'] = companyResponse.id;

    // Retira as mascaras
    user['user_cpf'] = unmask(user['user_cpf']);
    user['user_phone'] = unmask(user['user_phone']);
    user['user_addr_cep'] = unmask(user['user_addr_cep']);

    // Conversão de data
    user['user_birth'] = brDatetoUsa(user['user_birth']);

    $.post("/users", user, function(userResponse){

    })
    .fail(function (data) {
        console.log('falha: ' + data['error'] + ' msg:' + data['message']);
    })
  })
  .fail(function (data) {
    console.log('falha: ' + data['error'] + ' msg: ' + data['message']);
  });
}

$(document).ready(function(){
  initValidator();
  initMask();
  initWizard();
});

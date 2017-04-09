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
  // Se o usuário estiver voltando, não preciso validar
  if ( context.fromStep > context.toStep )
  return true;

  var stepNumber = context.fromStep;

  // valido o passo do qual estou saindo
  var isValid = validateStep(stepNumber);

  // Caso seja válido e eu estou saindo do step 1
  // vou fazer a requisição de cnpj para autocomplete do step 2
  if(isValid && stepNumber == 1) requestCnpj();

  return isValid;
}

function formSubmit(objs, context)
{
  // Validação de todos os passos
  // No primeiro passo errado, vou voltar para ele
  if ( !validateStep(1) ) {
    $("#wizard").smartWizard('goToStep', 1);
    reconfigureWizardView(1);
    return;
  } else if (!validateStep(2)) {
    $("#wizard").smartWizard('goToStep', 2);
    reconfigureWizardView(2);
    return;
  }else if (!validateStep(3)) {
    $("#wizard").smartWizard('goToStep', 3);
    reconfigureWizardView(3);
    return;
  }else if (!validateStep(4)) {
    $("#wizard").smartWizard('goToStep', 4);
    reconfigureWizardView(4);
    return;
  }else { // todos os passos são válidos
    store(storeSuccess, storeFailure); // cadastro da empresa e usuário
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

function store(success, failure)
{
  var company = packCompany();
  var user = packUser();
  var data = {
    '_token': $('meta[name="_token"]').attr('content'),
    'company': company,
    'user': user
  }

  $.post("/cadastro", data, function(companyResponse){
    // Cadastro deu certo
    success();
  })
  .fail(function (data) {
    var msg = data.responseJSON['message'];
    failure(msg);
  });

  startSpin();
}

function storeSuccess()
{
  console.log("foi");
  stopSpin();
  showConfirmation();
  // $('#modal_signup_confirmation').modal('show');
}

function storeFailure(msg)
{
  // para spin e fecha modal
  stopSpin(true);
  $('#signup-error-msg').text(msg);
  $('#signup-error').show().removeClass('hidden');
}

function packUser()
{
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

  // Retira as mascaras
  user['user_cpf'] = unmask(user['user_cpf']);
  user['user_phone'] = unmask(user['user_phone']);
  user['user_addr_cep'] = unmask(user['user_addr_cep']);

  // Conversão de data
  user['user_birth'] = brDatetoUsa(user['user_birth']);

  return user;
}

function packCompany()
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

  return company;
}

function startSpin()
{
  $('#modal_signup_confirmation_header h4').text('Por favor, aguarde um momento enquanto concluímos seu cadastro...');
  $('#modal_signup_confirmation_body').spin();

  $('#modal_signup_confirmation').modal('show');
}

function stopSpin(closeModal = false)
{
  $('#modal_signup_confirmation_body').spin(false);
  if(closeModal) $('#modal_signup_confirmation').modal('hide');
}

function showConfirmation()
{
  // Tiro o seara-hide, hidden
  $('#modal_signup_confirmation_header h4').text('Cadastro Concluído com Sucesso!');
  $('#modal_signup_confirmation_content').removeClass('seara-hide');
  $('#modal_signup_confirmation .modal-footer').removeClass('hidden');
}

$(document).ready(function(){
  initValidator();
  initMask();
  initWizard();

  // Desabilita o enter para formulários
  $(document).on("keypress", "form", function(event) {
    return event.keyCode != 13;
  });

  // Redirecionamento para a página inicial
  $("#modal_signup_confirmation_button").click(function () {
    window.location.href = $(this).data('href');
  });
});


$('#el').spin();

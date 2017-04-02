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

$(document).ready(function(){
  initValidator();
  initMask();
  initWizard();
});

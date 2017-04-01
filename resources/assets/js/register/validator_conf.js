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
        window.Parsley.addMessage('en', 'seara', 'Digite um CNPJ Válido.');
        isValid = false;
      }
    }
    else {
      window.Parsley.addMessage('en', 'seara', 'Campo Obrigatório.');
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

  // Reconfiguração das views

  $('#form-step-1').parsley().on('form:validated', function() {
    reconfigureWizardView(1);
  });

  $('#form-step-2').parsley().on('form:validated', function() {
    reconfigureWizardView(2);
  });

  $('#form-step-3').parsley().on('form:validated', function() {
    reconfigureWizardView(3);
  });

  $('#form-step-4').parsley().on('form:validated', function() {
    reconfigureWizardView(4);
  });
}

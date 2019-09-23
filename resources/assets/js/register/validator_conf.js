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

function validaCPF(cpf)
 {
   var numeros, digitos, soma, i, resultado, digitos_iguais;
   digitos_iguais = 1;
   if (cpf.length < 11)
         return false;
   for (i = 0; i < cpf.length - 1; i++)
         if (cpf.charAt(i) != cpf.charAt(i + 1))
               {
               digitos_iguais = 0;
               break;
               }
   if (!digitos_iguais)
         {
         numeros = cpf.substring(0,9);
         digitos = cpf.substring(9);
         soma = 0;
         for (i = 10; i > 1; i--)
               soma += numeros.charAt(10 - i) * i;
         resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
         if (resultado != digitos.charAt(0))
               return false;
         numeros = cpf.substring(0,10);
         soma = 0;
         for (i = 11; i > 1; i--)
               soma += numeros.charAt(11 - i) * i;
         resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
         if (resultado != digitos.charAt(1))
               return false;
         return true;
         }
   else
       return false;
 }


function validateDate(datestring)
{
  // Padrão brasileiro DD-MM-YYYY
  var dateSplitted = datestring.split('/');

  var day = dateSplitted[0];    // dia
  var month = dateSplitted[1];  // mes
  var year = dateSplitted[2];   // ano

  var date = new Date(year + '-' + month + '-' + day);

  return (date instanceof Date && isFinite(date));

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

    case "data":
      if($('#user_birth').inputmask('isComplete')) { // verifica se está completo

        window.Parsley.addMessage('en', 'seara', 'Digite uma data válida.');
        isValid = validateDate($('#user_birth').val());

      } else { // incompleto
        window.Parsley.addMessage('en', 'seara', 'Campo Obrigatório.');
        isValid = false;
      }
      break;

    case "cpf":
      if( $('#user_cpf').inputmask('isComplete') ) { // verifica se está completo
        window.Parsley.addMessage('en', 'seara', 'Digite um CPF válido.');
        isValid = validaCPF( $('#user_cpf').inputmask('unmaskedvalue') );
      } else { // incompleto
        window.Parsley.addMessage('en', 'seara', 'Campo Obrigatório.');
        isValid = false;
      }
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

  window.Parsley.addValidator('full', {
    requirementType: 'string',
    validateString: function (value, requirement) {
      return $(requirement).inputmask('isComplete');
    },
    messages: {
      en: 'Campo Obrigatório'
    }
  });

  // Mensagens
  window.Parsley.addMessage('en', 'required', 'Campo Obrigatório.');
  $('#user_email').attr('data-parsley-type-message', 'Digite um email válido.');
  $('#user_password').attr('data-parsley-minlength-message', 'A senha deve conter no mínimo 6 caracteres.');
  $('#user_confirm_password').attr('data-parsley-equalto-message', 'As senhas devem ser idênticas.');

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
}

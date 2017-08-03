/**
* Faz uma requisição no serviço receitaws para autocompletar os campos da empresa
*/
function requestCnpj()
{
  // url do recietaws
  var url = 'http://receitaws.com.br/v1/cnpj/'+$("#company_cnpj").inputmask("unmaskedvalue");

  return $.ajax({
    url: url,
    dataType: 'jsonp',
    jsonp: 'callback',
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
    },
    timeout: 3000
  });
}

function requestCEP()
{
  SearaLoader.showModal( 'Atualizando endereço...' );
  $.ajax({
    url: "http://correiosapi.apphb.com/cep/"+$("#user_cep").inputmask("unmaskedvalue"),
    dataType: 'jsonp',
    jsonp: 'callback',
    async: true,
    success: function(data){
      $("#user_street").val(data.tipoDeLogradouro + " " + data.logradouro);
      $("#user_city").val(data.cidade);
      $("#user_state").val(data.estado);
      $("#user_district").val(data.bairro);

      // Apenas para atualização da view
      $("#form-step-4").parsley().validate();

      // Fecho o modal de loader
      SearaLoader.hideModal();
    },
    error: function(){
      SearaLoader.hideModal();
    },
    timeout: 3000
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
  $("#user_cpf").inputmask("999.999.999-99"); //specifying options
  $("#user_phone").inputmask("(99)99999-9999"); //specifying options
  $("#user_birth").inputmask("99/99/9999"); //specifying options
  $("#user_cep").inputmask("99.999-999",{
    "oncomplete": requestCEP
  });
}

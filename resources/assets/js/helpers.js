function packForm(formSel, data = {})
{
  $(formSel).serializeArray().map(function(x){
    data[x.name] = x.value;
  });

  return data;
}

function populateForm(formSelector, data) {
  $.each(data, function(key, value){
    $('[name='+key+']', formSelector).val(value);
  });
}

function brDatetoUsa(datestring)
{
  var dateSplitted = datestring.split('/');
  return dateSplitted[2] + '-' + dateSplitted[1] + '-' + dateSplitted[0];
}

function usaDatetoBr(datestring)
{
  var dateSplitted = datestring.split('-');
  return dateSplitted[2] + '/' + dateSplitted[1] + '/' + dateSplitted[0];
}

function dataAtualFormatada(dt){
  var data = new Date(dt),
      dia  = data.getDate().toString(),
      diaF = (dia.length == 1) ? '0'+dia : dia,
      mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
      mesF = (mes.length == 1) ? '0'+mes : mes,
      anoF = data.getFullYear();
  return diaF+"/"+mesF+"/"+anoF;
}

function formattedCurrentDate() {
  const now = new Date();
  return now.getDate().toString().padStart(2, '0')
    + (now.getMonth() + 1).toString().padStart(2, '0')
    + now.getFullYear().toString();
}

function reloadTable(tableId) {
  $("#" + tableId).DataTable().ajax.reload();
}

function convertBrCoinToFloat(valor){

  if(valor === ""){
    valor =  0;
  }else{
    valor = valor.replace(".","");
    valor = valor.replace(",",".");
    valor = parseFloat(valor);
  }
  return valor;

}

function formatFloatToBrCoin(value) {
  let formatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  });

  return formatter.format(value).replace('R$', '').trim();
}

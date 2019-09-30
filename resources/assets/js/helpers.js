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

function packForm(formSel, data = {})
{
  $(formSel).serializeArray().map(function(x){
    data[x.name] = x.value;
  });

  return data;
}

function brDatetoUsa(datestring)
{
  var dateSplitted = datestring.split('/');
  return dateSplitted[2] + '-' + dateSplitted[1] + '-' + dateSplitted[0];
}

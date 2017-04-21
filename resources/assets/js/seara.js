var seara = (function(){

  var routes = {};

  function getToken()
  {
    return Cookies.get("XSRF-TOKEN");
  }

  function init(laravelRoutes)
  {
    console.log(laravelRoutes);
    routes = laravelRoutes;
  }

  function createReceiptCompany(receiptData, callback)
  {
    // Criação é via post. Retorno as mesmas promessas
    return $.ajax({
      url: routes.receiptCompany,
      type: 'POST',
      data: receiptData,
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: 'json'
    })
    .done(function(data){
      callback(data);
    });
  }

  function showReceiptCompany(id, callback)
  {
    return $.ajax({
      url: routes.receiptCompany + "/" + id,
      type: 'GET',
      headers: { 'X-XSRF-TOKEN': getToken() },
    })
    .done(function(data){
      callback(data);
    });
  }

  function updateReceiptCompany(id, receiptData, callback)
  {
    // Atualização é via put
    return $.ajax({
      url: routes.receiptCompany + "/" + id,
      type: 'PUT',
      data: receiptData,
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: 'json'
    })
    .done(function(data){
      callback(data);
    });
  }

  function destroyReceiptCompany(id, callback)
  {
    // Atualização é via delete
    return $.ajax({
      url: routes.receiptCompany + "/" + id,
      type: 'DELETE',
      headers: { 'X-XSRF-TOKEN': getToken() }
    })
    .done(function(data){
      callback(data);
    });
  }

  return {
    init: init,
    createReceiptCompany: createReceiptCompany,
    showReceiptCompany: showReceiptCompany,
    updateReceiptCompany: updateReceiptCompany,
    destroyReceiptCompany: destroyReceiptCompany
  }

})();

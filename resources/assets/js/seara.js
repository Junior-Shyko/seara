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

  return {
    init: init,
    createReceiptCompany: createReceiptCompany
  }

})();

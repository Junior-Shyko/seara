/**
 * Módulo de encapuslamento das chamadas ao servidor
 * Esse módulo possui diversas funções auxiliares que facilitam o acesso
 * a recursos no servidor (Resource Controllers).
 */
var seara = (function(){

  /**
   * Rotas do servidor para cada recurso
   * @type {Object}
   */
  var routes = {};

  /**
   * Retorna o token de acesso para realizar requisições no servidor
   * @return {str} Token de acesso
   */
  function getToken()
  {
    return Cookies.get("XSRF-TOKEN");
  }

  /**
   * Retorna a URL para um dado recurso
   * @param  {str} resourceName nome do recurso a ser acessado
   * @return {str}              url do recurso
   */
  function resourceURL(resourceName)
  {
    return routes[resourceName];
  }

  /**
   * Inicia o módulo seara. Aqui deve ser passado um objeto que associa a url
   * raiz de cada recurso (resource.index). Esse método deve ser chamado no layout
   * padrão do projeto, ou em cada view onde será utilizado o módulo.
   * @param  {Object} laravelRoutes Rotas do servidor
   */
  function init(laravelRoutes)
  {
    routes = laravelRoutes;
  }

  /**
   * Cria um recurso no servidor (resource.store)
   * @param  {str}      resourceName nome do recurso a ser criado
   * @param  {Object}   resourceData Json que representa o recurso (deve estar de acordo com o Eloquent)
   * @param  {Function} callback     Callback a ser executada quando finalizar com sucesso
   * @return {JHXR}                  Promessa Ajax.
   */
  function storeResource(resourceName, resourceData, callback)
  {
    // Criação é via post. Retorno as mesmas promessas
    return $.ajax({
      url: resourceURL(resourceName),
      type: 'POST',
      data: resourceData,
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: 'json'
    })
    .done(function(data){
      callback(data);
    });
  }

  function showResource(resourceName, id, callback)
  {
    return $.ajax({
      url: resourceURL(resourceName) + "/" + id,
      type: 'GET',
      headers: { 'X-XSRF-TOKEN': getToken() },
    })
    .done(function(data){
      callback(data);
    });
  }

  function updateResource(resourceName, id, resourceData, callback)
  {
    // Atualização é via put
    return $.ajax({
      url: resourceURL(resourceName) + "/" + id,
      type: 'PUT',
      data: resourceData,
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: 'json'
    })
    .done(function(data){
      callback(data);
    });
  }

  function destroyResource(resourceName, id, callback)
  {
    // Atualização é via delete
    return $.ajax({
      url: resourceURL(resourceName) + "/" + id,
      type: 'DELETE',
      headers: { 'X-XSRF-TOKEN': getToken() }
    })
    .done(function(data){
      callback(data);
    });
  }

  return {
    init: init,
    storeReceiptCompany: function (data, callback) { return storeResource('receiptCompany', data, callback) },
    showReceiptCompany: function (id, callback) { return showResource('receiptCompany', id, callback) },
    updateReceiptCompany: function (id, data, callback) { return updateResource('receiptCompany', id, data, callback) },
    destroyReceiptCompany: function (id, callback) { return destroyResource('receiptCompany', id, callback) }
  }

})();

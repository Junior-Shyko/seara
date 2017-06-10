/**
 * Módulo de encapuslamento das chamadas ao servidor
 * Esse módulo possui diversas funções auxiliares que facilitam o acesso
 * a recursos no servidor (Resource Controllers).
 */
var Seara = function(_resourceURL){

  /**
   * Retorna o token de acesso para realizar requisições no servidor
   * @return {str} Token de acesso
   */
  function getToken()
  {
    return Cookies.get("XSRF-TOKEN");
  }

  /**
   * Inicia o módulo seara. Aqui deve ser passado um objeto que associa a url
   * raiz de cada recurso (resource.index). Esse método deve ser chamado no layout
   * padrão do projeto, ou em cada view onde será utilizado o módulo.
   * @param  {Object} laravelRoutes Rotas do servidor
   */
  function init(resourceURL)
  {
    _resourceURL = resourceURL;
  }

  /**
   * Cria um recurso no servidor (resource.store)
   * @param  {Object}   resourceData Json que representa o recurso (deve estar de acordo com o Eloquent)
   * @param  {Function} callback     Callback a ser executada quando finalizar com sucesso
   * @return {JHXR}                  Promessa Ajax.
   */
  function storeResource(resourceData, callback)
  {
    // Criação é via post. Retorno as mesmas promessas
    return $.ajax({
      url: _resourceURL,
      type: 'POST',
      data: resourceData,
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: 'json'
    })
    .done(function(data){
      callback(data);
    });
  }

  function showResource(id, callback)
  {
    return $.ajax({
      url: _resourceURL + "/" + id,
      type: 'GET',
      headers: { 'X-XSRF-TOKEN': getToken() },
    })
    .done(function(data){
      callback(data);
    });
  }

  function updateResource(id, resourceData, callback)
  {
    // Atualização é via put
    return $.ajax({
      url: _resourceURL + "/" + id,
      type: 'PUT',
      data: resourceData,
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: 'json'
    })
    .done(function(data){
      callback(data);
    });
  }

  function destroyResource(id, callback)
  {
    // Atualização é via delete
    return $.ajax({
      url: _resourceURL + "/" + id,
      type: 'DELETE',
      headers: { 'X-XSRF-TOKEN': getToken() }
    })
    .done(function(data){
      callback(data);
    });
  }

  // Métodos públicos
  return {
    init: init,
    storeResource: storeResource,
    showResource: showResource,
    updateResource: updateResource,
    destroyResource: destroyResource
  }

};

/**
 * Object Constructor que encapsula o acesso a recursos no sistema
 * @param {str} resourceURL URL base do recurso
 */
function ResourceModel(resourceURL)
{
  this._seara = new Seara(resourceURL);
  // this._seara.init(resourceURL);
}

ResourceModel.prototype.create = function (data, callback) {
  return this._seara.storeResource(data, callback);
};

ResourceModel.prototype.read = function (id, callback) {
  return this._seara.showResource(id, callback);
};

ResourceModel.prototype.update = function (id, data, callback) {
  return this._seara.updateResource(id, data, callback);
};

ResourceModel.prototype.delete = function (id, callback) {
  return this._seara.destroyResource(id, callback);
};

String.prototype.isEmpty = function() {
    return (this.length === 0 || !this.trim());
};

$.LoadingOverlaySetup({
  image: SearaApp.assetURL + 'img/ring.svg'
});

/**
 * Loader para Seara
 */
var SearaLoader = (function(){

   // Funções para o Loading Overlay
  function showOverlay(sel)
  {
      if ( sel )
      {
          if ( sel.isEmpty() )
              $.LoadingOverlay("show");
          else
              $(sel).LoadingOverlay("show");
      }
      else
          $.LoadingOverlay("show");
  }

  function hideOverlay(sel)
  {
      if ( sel )
      {
          if ( sel.isEmpty() )
              $.LoadingOverlay("hide");
          else
              $(sel).LoadingOverlay("hide");
      }
      else
          $.LoadingOverlay("hide");
  }

  function showModal( title = '' )
  {
    swal({
      title: title,
      imageUrl: SearaApp.assetURL + 'img/ring.svg',
      showConfirmButton: false
    })
  }

  function closeModal()
  {
    swal.close();
  }

  return {
    show: showOverlay,
    hide: hideOverlay,
    showModal: showModal,
    hideModal: closeModal
  }

}());

var SearaAlert = (function(){

  function alertError( title = '', text = '', timer = null )
  {
    return swal({
      title: title,
      text: text,
      type: 'error',
      timer: timer
    });
  }

  function alertSuccess( title = '', text = '', timer = null )
  {
    return swal({
      title: title,
      text: text,
      type: 'success',
      timer: timer
    });
  }

  return {
    error: alertError,
    success: alertSuccess
  }

}());
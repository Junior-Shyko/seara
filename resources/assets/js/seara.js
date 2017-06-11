function baseURL( url )
{
  url = url.replace(/^\//, '');
  url = url.replace(/\/$/, '');

  return SearaApp.baseURL + url + '/';
}

$.LoadingOverlaySetup({
  image: SearaApp.assetURL + 'appimg/ring.svg'
});

/**
 * Object Constructor que encapsula o acesso a recursos no sistema
 * @param {str} resourceURL URL base do recurso
 */
function ResourceModel(resourceURL){
  this.resourceURL = resourceURL;
}

ResourceModel.prototype.create = function (data, callback) {
  return SearaAjax.post( this.resourceURL, data, callback );
};

ResourceModel.prototype.read = function (id, callback) {
  return SearaAjax.get( this.resourceURL + '/' + id, callback );
};

ResourceModel.prototype.update = function (id, data, callback) {
  return SearaAjax.put( this.resourceURL + '/' + id, data, callback );
};

ResourceModel.prototype.delete = function (id, callback) {
  return SearaAjax.delete( this.resourceURL + '/' + id, callback );
};

String.prototype.isEmpty = function() {
    return (this.length === 0 || !this.trim());
};

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
      imageUrl: SearaApp.assetURL + 'appimg/ring.svg',
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

var SearaAjax = (function(){
  function getToken()
  {
    // return Cookies.get("XSRF-TOKEN");
    return $('meta[name="csrf-token"]').attr('content');
    // return $('meta[name="_token"]').attr('content');
  }

  function ajaxCall(type, url, data, callback, dataType = 'Json')
  {
    var ajaxOptions = {
      url: baseURL(url),
      headers: { 'X-CSRF-TOKEN': getToken() },
      dataType: dataType,
      type: type,
      method: type
    };

    if ( type == 'POST' || type == 'PUT' )
    {
      if ( data != null )
        ajaxOptions.data = data;

      console.log( 'POST' )
    }

    if ( callback != null )
      ajaxOptions.success = callback;

    console.log( ajaxOptions );

    return $.ajax( ajaxOptions );

  }

  function postAjax(url, data, callback = null, dataType = 'json')
  {
    return ajaxCall('POST', url, data, callback, dataType);
  }

  function getAjax(url, callback = null, dataType = 'json')
  {
    return ajaxCall('GET', url, null, callback, dataType);
  }

  function deleteAjax(url, callback = null, dataType = 'json')
  {
    return ajaxCall('DELETE', url, null, callback, dataType);
  }

  function putAjax(url, data, callback = null, dataType = 'json')
  {
    return ajaxCall('PUT', url, data, callback, dataType);
  }

  return {
    post: postAjax,
    get: getAjax,
    delete: deleteAjax,
    put: putAjax
  };

}());

function SearaTable(tableID, url, columns, singular = 'registro', plural = 'registros'){

  this.tableID = tableID;
  this.url = baseURL(url);
  this.columns = columns;
  this.singular = singular;
  this.plural = plural;

};

SearaTable.prototype.reloadTable = function() {
  $("#" + this.tableID).DataTable().ajax.reload();
}

SearaTable.prototype.loadTable = function (){

    $('#'+this.tableID).DataTable({
      processing: true,
      serverSide: true,
      ajax: this.url,
      columns: this.columns,
      language: {
        "lengthMenu": "Exibir _MENU_ " + this.plural + " por página",
        "zeroRecords": "Nenhum " + this.singular + " cadastrado para essa pesquisa",
        "infoEmpty": "Exibindo 0 de 0 " + this.plural,
        "emptyTable": "Nenhum " + this.singular + " cadastrado",
        "info": "Exibindo página _PAGE_ de _PAGES_",
        "infoFiltered": "(filtrados de _MAX_ " + this.plural + ")",
        "search": "Pesquisar:",
        "paginate": {
          "previous": "Anterior",
          "next": "Próximo",
          "first": "Primeiro",
          "last": "Último"
        }
      }
    });
}

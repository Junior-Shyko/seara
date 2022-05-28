function baseURL( url )
{
  url = url.replace(/^\//, '');
  url = url.replace(/\/$/, '');

  return SearaApp.baseURL + url;
}

function asset( url )
{
  return SearaApp.assetURL + url;
}

$.LoadingOverlaySetup({
  image: SearaApp.assetURL + 'img/ring.svg'
});

/**
 * Object Constructor que encapsula o acesso a recursos no sistema
 * @param {string} resourceURL URL base do recurso
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
      imageUrl: asset('img/ring.svg'),
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
    return Cookies.get("XSRF-TOKEN");
  }

  function ajaxCall(type, url, data, callback, dataType = 'Json')
  {
    var ajaxOptions = {
      url: baseURL(url),
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: dataType,
      type: type,
      method: type
    };

    if ( type == 'POST' || type == 'PUT' )
    {
      if ( data != null )
        ajaxOptions.data = data;
    }

    if ( callback != null )
      ajaxOptions.success = callback;

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

function SearaTable(tableID, url, columns, singular = 'registro', plural = 'registros', dataFunc = () => {}){

  this.tableID = tableID;
  this.url = url;
  this.columns = columns;
  this.singular = singular;
  this.plural = plural;
  this.dataFunc = dataFunc;

};

SearaTable.prototype.reloadTable = function() {
  $("#" + this.tableID).DataTable().ajax.reload();
}

SearaTable.prototype.loadTable = function () {
  let thisSearaTable = this;
  let table = $('#'+this.tableID).DataTable({
    processing: true,
    serverSide: true,
    dom: 'lBfrtip',
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    buttons: [
      {
        extend: 'pdf',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excelHtml5',
        exportOptions: {
          columns: ':visible',
          format: {
            body: function ( data, row, column, node ) {
                if (node.className.split(/\s+/).includes("formatted_number")) {
                    return convertBrCoinToFloat(data);
                }
                return data;
            }
          }
        }
      },
      {
        extend: 'colvis',
        text: 'Selecionar colunas'
      }
    ],
    ajax: {
      url: this.url,
      data: d => {
        d.query = thisSearaTable.dataFunc();
      }
    },
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

  let selector = $('#company-table_wrapper > div:nth-child(1) > div:nth-child(1)');
  table.buttons().container().appendTo(selector);
};


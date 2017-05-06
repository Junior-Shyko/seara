function packReceiptData()
{
  var receiptData = packForm("#form-receipt");
  receiptData['receipt_value'] = parseFloat(receiptData['receipt_value'].replace(/\./g, '').replace(',','.'));
  receiptData['receipt_date'] = brDatetoUsa(receiptData['receipt_date']);

  return receiptData;
}

function populateForm(frm, data) {
  $.each(data, function(key, value){
    $('[name='+key+']', frm).val(value);
  });
}

function loadData(data) {
  data['receipt_date'] = usaDatetoBr( data['receipt_date'] );
  data['receipt_value'] = parseFloat( data['receipt_value'] ).toFixed(2);
  populateForm("#form-receipt", data);
  reloadAllMasks();
}

function currentDate()
{
  d = new Date();

  return ( "0" + d.getDate() ).slice(-2) + "/" + ( "0" + (d.getMonth() + 1) ).slice(-2) + "/" + d.getFullYear();
}

function showForm()
{
  $("#form-receipt").parsley().reset();
  $("#modal-receipt").modal('show');
}

function closeForm()
{
  $("#modal-receipt").modal('hide');
}

function reloadTable()
{
  $("#receipts-table").DataTable().ajax.reload();
}

/* IMPLEMENTAÇÃO DAS ACTIONS */

function createReceipt(id)
{
  // Ação Salvar
  $("#form-save-btn").off('click');
  $("#form-save-btn").on('click', function(){

    if( $("#form-receipt").parsley().validate() )
    {
      // Caso a validação esteja ok, vou registrar o recibo
      receiptData = packReceiptData();

      seara.storeReceiptCompany(receiptData, function(data){
        reloadTable();
      })
      .always(function (data) {
        notify.response(data);
      });

      closeForm();
    }

  });

  $.get('companies/'+id, function(company){
    formData = {
      "receipt_value": '',
      "receipt_received_from": '',
      "receipt_reference": '',
      "receipt_local": company.company_addr_city,
      "receipt_date": currentDate(),
      "receipt_emitter": company.company_fantasy,
      "receipt_document": company.company_cnpj
    }
    populateForm("#form-receipt", formData);
    reloadAllMasks();
    showForm();
  });
}

function editReceipt(id)
{
  // Ação Salvar
  $("#form-save-btn").off('click');
  $("#form-save-btn").on('click', function(){

    if( $("#form-receipt").parsley().validate() )
    {
      // Caso a validação esteja ok, vou registrar o recibo
      receiptData = packReceiptData();

      seara.updateReceiptCompany(id, receiptData, function(data){
        reloadTable();
      })
      .always(function (data) {
        notify.response(data);
      });

      closeForm();
    }

  });

  seara.showReceiptCompany(id, function (data) {
    loadData(data);
    showForm();
  });

}

function cloneReceipt(id)
{
  // Ação Salvar
  $("#form-save-btn").off('click');
  $("#form-save-btn").click(function(){

    if( $("#form-receipt").parsley().validate() )
    {
      // Caso a validação esteja ok, vou registrar o recibo
      receiptData = packReceiptData();

      seara.storeReceiptCompany(receiptData, function(data){
        reloadTable();
      })
      .always(function (data) {
        notify.response(data);
      });

      closeForm();
    }

  });

  $.get('receipt-company/'+id, function(data){
    loadData(data);
    $('#receipt_value').val('');
    showForm();
  });
}

function deleteReceipt(id)
{

  $("#modal-delete-receipt").modal("show");

  // Eventos
  $("#modal-delete-receipt-btn").off("click");

  $("#modal-delete-receipt-btn").click(function (data) {

    seara.destroyReceiptCompany(id, function (data) {
      reloadTable();
    })
    .always(function (data) {
      notify.response(data);
    });

    $("#modal-delete-receipt").modal("hide");

  });

}

$(document).ready(function() {

  $('#receipts-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: datatablesURL,
    columns: [
      { data: 'receipt_id', name: 'receipt_id' },
      { data: 'receipt_received_from', name: 'receipt_received_from' },
      { data: 'receipt_reference', name: 'receipt_reference' },
      { data: 'receipt_value', name: 'receipt_value' },
      { data: 'receipt_local', name: 'receipt_local' },
      { data: 'receipt_date', name: 'receipt_date' },
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
    language: {
      "lengthMenu": "Exibir _MENU_ recibos por página",
      "zeroRecords": "Nenhum recibo cadastrado para essa pesquisa",
      "infoEmpty": "Exibindo 0 de 0 recibos",
      "emptyTable": "Nenhum redibo cadastrado",
      "info": "Exibindo página _PAGE_ de _PAGES_",
      "infoFiltered": "(filtrados de _MAX_ recibos)",
      "search": "Pesquisar:",
      "paginate": {
        "previous": "Anterior",
        "next": "Próximo",
        "first": "Primeiro",
        "last": "Último"
      }
    },
    order: [[0, "desc"]]
  });

  window.Parsley.addMessage('en', 'required', 'Campo Obrigatório.');

  // Focagem automática no primeiro elemento
  $('#modal-receipt').on('shown.bs.modal', function () {
    $('#receipt_value').focus();
  })
  // initMask();

});

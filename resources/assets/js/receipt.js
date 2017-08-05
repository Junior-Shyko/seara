var receiptCompany = new ResourceModel('receipt-company');
var company = new ResourceModel('companies');
var receiptTable;


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

function loadData(data) 
{
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
    receiptTable.reloadTable();
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

      receiptCompany.create(receiptData, function(data){
        reloadTable();
      })
      .always(function (data) {
        notify.response(data);
      });

      closeForm();
    }

});

  company.read(id, function(data){
    formData = {
        "receipt_value": '',
        "receipt_received_from": '',
        "receipt_reference": '',
        "receipt_local": data.company_addr_city,
        "receipt_date": currentDate(),
        "receipt_emitter": data.company_fantasy,
        "receipt_document": data.company_cnpj
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

      receiptCompany.update(id, receiptData, function(data){
        reloadTable();
      })
      .always(function (data) {
        notify.response(data);
      });

      closeForm();
    }

});

  receiptCompany.read(id, function (data) {
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

      receiptCompany.create(receiptData, function(data){
        reloadTable();
      })
      .always(function (data) {
        notify.response(data);
      });

      closeForm();
    }

});

  // Atualização no form
  receiptCompany.read(id, function(data){
    loadData(data);
    $('#receipt_value').focus();
    showForm();
  });
}

function deleteReceipt(id)
{
    swal({
        title: 'Atenção',
        text: 'O recibo será excluído, deseja confirmar?',
        type: 'warning',
        showCancelButton: true
    })
    .then(function(){

        SearaLoader.showModal('Excluindo recibo...');
        receiptCompany.delete(id, function (response) {
            notify.response(response);
            reloadTable();
        })
        .fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        })
        .always(function(){
            SearaLoader.hideModal();
        });

    });

}

function showReceiptSettings()
{
    $('#modal-receipt-settings').modal('show');
}

$(document).ready(function() {

    var colunas = [
    { data: 'receipt_received_from', name: 'receipt_received_from' },
    { data: 'receipt_reference', name: 'receipt_reference' },
    { data: 'receipt_value', name: 'receipt_value', className: 'no-break' },
    { data: 'receipt_local', name: 'receipt_local' },
    { data: 'receipt_date', name: 'receipt_date', className: 'no-break' },
    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'no-break' }
    ];

    receiptTable = new SearaTable( 
        'receipts-table',
        'recibo-empresa/datatable',
        colunas,
        'recibo',
        'recibos'
        );

    receiptTable.loadTable();

    window.Parsley.addMessage('en', 'required', 'Campo Obrigatório.');

  // Focagem automática no primeiro elemento
  $('#modal-receipt').on('shown.bs.modal', function () {
    $('#receipt_value').focus();
  })
  // initMask();

});

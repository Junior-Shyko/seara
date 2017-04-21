function populateForm(frm, data) {
  $.each(data, function(key, value){
    $('[name='+key+']', frm).val(value);
  });
}

function loadData(data) {
  data['receipt_date'] = usaDatetoBr( data['receipt_date'] );
  data['receipt_value'] = data['receipt_value'].toFixed(2);
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

/* IMPLEMENTAÇÃO DAS ACTIONS */

function createReceipt(id)
{
  // Ação Salvar
  $("#form-save-btn").on('click', function(){
    $("#form-receipt").parsley().validate();
  });

  $.get('companies/'+id, function(company){
    formData = {
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
  $("#form-save-btn").on('click', function(){
    $("#form-receipt").parsley().validate();
  });

  $.get('receipt-company/'+id, function(data){
    loadData(data);
    showForm();
  });
}

function cloneReceipt(id)
{
  // Ação Salvar
  $("#form-save-btn").on('click', function(){
    $("#form-receipt").parsley().validate();
  });

  $.get('receipt-company/'+id, function(data){
    loadData(data);
    $('#receipt_value').val('');
    showForm();

    $('#modal-receipt').on('shown.bs.modal', function () {
      $('#receipt_value').focus();
    })

  });
}

function deleteReceipt(id)
{
  $("#modal_delete_receipt_text").html("Você deseja mesmo excluir esse recibo?");
  $("#form-delete-receipt").attr('action', 'recibo-empresa/'+id);
  $("#modal_delete_receipt").modal('show');
}

function initMask()
{
  $("#receipt_value").maskMoney(
    {
      prefix:'R$ ',
      allowNegative: true,
      thousands:'.',
      decimal:',',
      affixesStay: false
    }
  );

  $("#receipt_date").inputmask('99/99/9999');
}

function removeMasks()
{
  var datestring = $("#receipt_date").val();
  $("#receipt_date").inputmask('remove');
  $("#receipt_date").val( brDatetoUsa(datestring) );

  var receipt_value = $("#receipt_value").maskMoney('unmasked')[0]
  $("#receipt_value").maskMoney('destroy');
  $("#receipt_value").val( receipt_value );
}

function storeReceipt()
{
  var formSel = "#form-new-receipt";

  if( $(formSel).parsley().validate() ) {
    // Caso tudo esteja válido, vou retirar as máscaras
    // e dar um submit no form
    $("#modal_create_receipt").modal('hide');
    removeMasks();
    $(formSel).submit();
    initMask(); // aplico novamente as mascaras pois ainda posso usar o modal
  }

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
  // initMask();

});

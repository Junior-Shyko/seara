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
    "language": {
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
    }
  } );


  window.Parsley.addMessage('en', 'required', 'Campo Obrigatório.');
  initMask();

});

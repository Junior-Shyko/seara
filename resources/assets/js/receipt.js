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

});

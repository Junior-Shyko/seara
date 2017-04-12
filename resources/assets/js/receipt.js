$(document).ready(function() {
  $('#receipts-table').DataTable({
    "language": {
      "zeroRecords": "Não há registro para mostrar",
      "infoEmpty": "Sem registro para mostrar",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoFiltered": " - filtrando de _MAX_ registro",
      "paginate": {
        "previous": "Anterior",
        "next": "Próximo",
        "first": "Primeiro",
        "last": "Último"
      }
    }
  } );
});

var SearaTable = function (tableID, url, columns, singular, plural){

  function loadTable()
  {
    $('#'+tableID).DataTable({
      processing: true,
      serverSide: true,
      ajax: url,
      columns: columns,
      language: {
        "lengthMenu": "Exibir _MENU_ " + plural + " por página",
        "zeroRecords": "Nenhum " + singular + " cadastrado para essa pesquisa",
        "infoEmpty": "Exibindo 0 de 0 " + plural,
        "emptyTable": "Nenhum " + singular + " cadastrado",
        "info": "Exibindo página _PAGE_ de _PAGES_",
        "infoFiltered": "(filtrados de _MAX_ " + plural + ")",
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
  }

  function reloadTable()
  {
    $("#" + tableID).DataTable().ajax.reload();
  }

  return {
    loadTable: loadTable,
    reloadTable: reloadTable
  }
};

$(document).ready(function () {

    var colunas = [
        { data: 'data_open', name: 'data_open' },
        { data: 'data_close', name: 'data_close' },
        { data: 'id_user_open', name: 'id_user_open'},
        { data: 'id_user_close', name: 'id_user_close'},
        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'no-break' }
    ];
  
    userPermissionTable = new SearaTable( 
      'table_settings_box',
      SearaApp.baseURL + 'caixa/datatable',
      colunas,
      'registro',
      'registros'
    );
    userPermissionTable.loadTable();

    $('#data_open_box').mask('00/00/0000');
    $('#data_close_box').mask('00/00/0000');

});
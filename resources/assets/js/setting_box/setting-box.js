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

$(function () {

 
});

function editBoxOpenClose(id)
{
  let url = SearaApp.baseURL+'caixa/editar/'+id;
  window.location.href=url
}

function alterarCaixa(id)
{
  if($("#data_close_box_edit").val() !== "")
  {
    // SearaAlert.confirm('Deseja realmente fechar esse caixa?', 'Fechar Caixa', 'Desistir', id);
    swal({
      title: 'Deseja realmente fechar esse caixa?',
      showCancelButton: true,
      confirmButtonText: 'Fechar Caixa',
      cancelButtonText: 'Desistir'
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      console.log(result)
      if (result) {
        // Swal.fire('Saved!', '', 'success')
        // form-edit-box
        updateSettingBox(id);

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }else{
    console.log('id', id)
  }
}

function updateSettingBox(id)
{
  var form = $("#form-edit-box").serialize();
  console.log({form});
  $.ajax({
      type: "put",
      url: SearaApp.baseURL + 'caixa/update/'+ id,
      data: form,
      dataType: "json",
      success: function (response) {
        console.log(response)
          // SearaAlert.success(response.message);
          // //REMOVENDO MODAL
          // $("#modalAcessClient").modal('hide');
          // reloadTable('table_permission_user')
      }
  });
}
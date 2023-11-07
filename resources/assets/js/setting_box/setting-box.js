$(document).ready(function () {

    var colunas = [
        { data: 'date_open', name: 'date_open' },
        { data: 'date_close', name: 'date_close' },
        { data: 'month', name: 'month' },
        { data: 'year', name: 'year' },
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

    // $('#date_open_box').mask('00/00/0000 00:00');
    // $('#date_close_box').mask('00/00/0000');
    jQuery.datetimepicker.setLocale('pt-BR');
    $("#date_open_box").datetimepicker({
      format:'d/m/Y H:i'
    });
    $("#date_open_box").datetimepicker({
      format:'d/m/Y H:i'
    });
    $("#date_close_box_edit").datetimepicker({
      format:'d/m/Y H:i'
    });

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
  if($("#date_close_box_edit").val() !== "")
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
        updateSettingBox(id);

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }else{
    console.log('id', id)
    updateSettingBox(id)
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
        if(response.status == 200)
        {
          notify.success('Sucesso!', response.message);
        }
      },
      error: function(res, status) {
        console.log(res, status)
        notify.error('Ops!', es.responseJSON.message);
      }
  });
}

function showConfirmOpenClose(id)
{
  swal({
    title: 'Deseja realmente reabrir esse caixa?',
    showCancelButton: true,
    confirmButtonText: 'Sim, reabrir!',
    cancelButtonText: 'Desistir'
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    console.log(result)
    if (result) {
      reopenBox(id);

    } else if (result.isDenied) {
      Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

function reopenBox(id)
{
  $.ajax({
    type: "put",
    url: SearaApp.baseURL + 'caixa/update/'+ id,
    data: {slug: 'open'},
    dataType: "json",
    success: function (response) {
      console.log({response})
    }
  });
}
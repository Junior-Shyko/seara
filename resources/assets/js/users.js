// HELPERS
function createUser()
{
  // Apresento o formulário
  $('#modal-form').modal('show');

  $('#modal-form-btn').off('click');
  $('#modal-form-btn').click(function(){

    // No submit, faço um pack no form
    var data = packForm('#form-user');

    // Envio para o servidor
    user.create(data, function(response){
      // no caso de sucesso, recarrego a tablea
      usersDataTable.reloadTable();
    })
    .always(function(response){
      notify.response(response);
    });

  });
}

function deleteUser(id)
{
}

$(document).ready(function(){
  usersDataTable.loadTable();
});

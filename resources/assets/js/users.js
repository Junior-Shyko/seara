// HELPERS
function createUser()
{
  // Apresento o formulário
  $('#modal-form').modal('show');

  $('#modal-form-btn').off('click');
  $('#modal-form-btn').click(function(){

    // No submit, faço um pack no form
    var data = packForm('#form-user');

    console.log(data);

    // Envio para o servidor
    user.create(data, function(response){
      // no caso de sucesso, recarrego a tablea
      //notifyResponse(response);
      notify.response(response);
      usersDataTable.reloadTable();
    })
    .fail(function(jqXHR){
      notify.response(jqXHR.responseJSON);
    });

  });
}

function deleteUser(id)
{
  swal({
    title: 'Tem certeza que deseja excluir esse usuário?',
    text: "Essa ação não poderá ser desfeita!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sim, excluir!',
    cancelButtonText: 'Não, cancelar!',
    allowOutsideClick: false
  }).then(function () {
    console.log('user id: ' + id);
    user.delete(id, function(response){
      usersDataTable.reloadTable();
    })
    .always(function(response){
      notify.response(response);
    });
  }, function(dismiss){})
}

$(document).ready(function(){
  usersDataTable.loadTable();
});

$(document).ready(function () {
  // $("#modalEditPermissionUser").modal('show');
  var colunas = [
      { data: 'nameUsers', name: 'nameUsers', id: 'id' },
      { data: 'nameComp', name: 'nameComp' },
      { data: 'nameRoles', name: 'nameRoles'},
      { data: 'namePerm', name: 'namePerm' },
      { data: 'action', name: 'action', orderable: false, searchable: false, className: 'no-break' }
  ];

  userPermissionTable = new SearaTable( 
    'table_permission_user',
    SearaApp.baseURL + 'api/user-permission',
    colunas,
    'registro',
    'registros'
  );
  userPermissionTable.loadTable();
    console.log({ userPermissionTable})


  $('#modalDeleteComponent').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    console.log(SearaApp.baseURL)
    modal.find('#idDelete').val(id)
    // modal.find('.modal-title').text('New message to ' + recipient)
    // modal.find('.modal-body input').val(recipient)
    $("#formDelete").attr('action', SearaApp.baseURL + 'users/'+id);
    // $("#formDelete").attr('method', 'DELETE');
    $("#idMethodFormDelete").attr('value','DELETE');
  })

  $('#modalEditPermissionUser').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    console.log({button})
    var modal = $(this)
    console.log(id)
    // modal.find('#idDelete').val(id)
  })

});

function editarPermission(id){
  
  $("#modalEditPermissionUser").modal('show');
  $("#role_user_id").val(id);
  $.get(SearaApp.baseURL + 'api/permission-user/'+id,
    function (data, textStatus, jqXHR) {
      console.log('nameRoles: ',data)
      data.forEach(element => {
        console.log({element})
        $("#info-role-user").html(element.nameRoles)
        $("#info-permission-user").html(element.namePerm)
       
      });
    }
  );
}

function deletePermission(id) {
  console.log({id})
  $("#modalDeletePermissionUser").modal('show');
  $("#title-h4-modal").html('Excluir permissão?');
  $("#body-delete-user-permission").html('Deseja realmente excluir essa permissão?');
  $("#idDeleteUserPermission").val(id);
}

$("#btn-delete-user-permission").click(function (e) { 
  e.preventDefault();
  SearaAjax.delete( 'permission/user/'+ $("#idDeleteUserPermission").val())
  .then(function (res) {
    console.log({res})
      SearaAlert.success('Excluído!',res.message , 2000);
      $("#modalDeletePermissionUser").modal('hide');
      $("#idDeleteUserPermission").val(null);
      // $('#modal-pay-receivable').modal('hide');
      // reloadTable('table-receivable');
  })
});

// $().change(function (e) { 
//   e.preventDefault();
//   console.log($("#select_role_users").value())
// });
$("#select_role_users").on('change', function() {
  console.log( $(this).find(":selected").text() );
  var dataUser = {
    user: $("#role_user_id").val(),
    role: $(this).find(":selected").text()
  }
  $.ajax({
    type: "post",
    url: SearaApp.baseURL + 'permission/alter-role',
    data: dataUser,
    dataType: "json",
    success: function (res) {
      new PNotify({
        title: res.title,
        text: res.message,
        type: res.type,
        styling: 'bootstrap3'
      });
      // userPermissionTable.loadTable()
      reloadTable('table_permission_user')
      setInterval(() => {
        $('#select_role_users').val('');
      }, 1500);
    }
  });
});

//ALTERAR A PERMISSÃO

$("#select_permission_users").on('change', function() {
  console.log( $(this).find(":selected").text() );
  var dataUser = {
    user: $("#role_user_id").val(),
    role: $(this).find(":selected").text()
  }
  $.ajax({
    type: "post",
    url: SearaApp.baseURL + 'permission/alter-role',
    data: dataUser,
    dataType: "json",
    success: function (res) {
      new PNotify({
        title: res.title,
        text: res.message,
        type: res.type,
        styling: 'bootstrap3'
      });
      // userPermissionTable.loadTable()
      reloadTable('table_permission_user')
      setInterval(() => {
        $('#select_role_users').val('');
      }, 1500);
    }
  });
});
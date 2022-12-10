$(document).ready(function () {
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
    var modal = $(this)
    console.log(id)
    // modal.find('#idDelete').val(id)
  })

});
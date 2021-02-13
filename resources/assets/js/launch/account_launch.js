$(document).ready(function () {
    $("#btn-save-account-launch").click(function (e) { 
        e.preventDefault();
        var form = $("#form-account-launch").serialize();
        SearaAjax.post('launch/account/create', form, function( response ){
			// notify.response(response);
			// companyTable.reloadTable();
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: response.status,
                styling: 'bootstrap3'
            });
		})
		.fail(function(jqXHR){
			notify.response(jqXHR.responseJSON);
            console.log(jqXHR);
		})
		.always(function(){
			//SearaLoader.hideModal();
            console.log('hideModal');
		});
    });
});

$(function () {
    let colunas = [
        {data: 'accountlaunch_type', name: 'accountlaunch_type'},
        {data: 'accountlaunch_name', name: 'accountlaunch_name'},
        {data: 'created_at', name: 'created_at'},
        {data: 'accountlaunch_id_user', name: 'accountlaunch_id_user'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'nowrap'},
    ];
    $('#account-launch-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: SearaApp.baseURL+'launch/account/all',
        columns: colunas
    });

    $('#modalEditAccountLaunch').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var idAccountLaunch = button.data('id') 
        var nameAccountLaunch = button.data('name') 
        var typeAccountLaunch = button.data('type') 
        var modal = $(this)
        modal.find('#modalAccountlaunch_type option[value='+typeAccountLaunch+']').attr('selected','selected');
        modal.find('#modalAccountlaunch_name').val(nameAccountLaunch);
        modal.find('#modalAccountLaunchId').val(idAccountLaunch);
    })
    // let data = packForm('#edit-form-edit-account-launch');
    $('#edit-form-edit-account-launch').on('click', function (event) {
        let idEdit = $('#modalAccountLaunchId').val();
        var form = $("#form-edit-account-launch").serialize();
        SearaAjax.put('/launch/account/' + idEdit, form)
        .then(function (response) {
            notify.response(response);
            $("#account-launch-table").DataTable().ajax.reload();
            $('#modalEditAccountLaunch').modal('hide');
        })
        .fail(function (jqXHR) {
            notify.response();
        })
        .always(function () {
            SearaLoader.hideModal();
        })
    });
});
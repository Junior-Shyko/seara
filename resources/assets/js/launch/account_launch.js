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
            $("#account-launch-table").DataTable().ajax.reload();
            $("#form-account-launch").each (function(){
              this.reset();
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
        {data: 'idAccountLaunch', name: 'idAccountLaunch'},
        {data: 'account_types_name', name: 'account_types_name'},
        {data: 'accountlaunch_name', name: 'accountlaunch_name'},
        {data: 'accountlaunch_history', name: 'accountlaunch_history'},
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
    // PARA EDIÇÃO DA CONTA DE MOVIMENTO DO CAIXA
    $('#modalEditAccountLaunch').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var idAccountLaunch = button.data('id') 
        var nameAccountLaunch = button.data('name') 
        var typeAccountLaunch = button.data('type') 
        var typeAccountHistory = button.data('history') 
        var modal = $(this)
        modal.find('#modalAccountlaunch_type option[value='+typeAccountLaunch+']').attr('selected','selected');
        var textSelect = modal.find('#modalAccountlaunch_type option:selected').text();
        $('#modalAccountlaunch_type').append(textSelect).trigger('change');
        modal.find('#modalAccountlaunch_name').val(nameAccountLaunch);
        modal.find('#modalAccountlaunch_history').val(typeAccountHistory);
        modal.find('#modalAccountLaunchId').val(idAccountLaunch);
    })
    $('#modalDeleteComponent').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        console.log(button);
        var idAccountLaunch = button.data('id') 
        var nameAccountLaunch = button.data('name')
        console.log(nameAccountLaunch)
        var typeAccountLaunch = ""; 
        var modal = $(this)
        if(button.data('type') == 1) {
            typeAccountLaunch = "Receita"
        }else{
            typeAccountLaunch = "Despesa"
        }
        modal.find('#nameAccountDeleteModal').html('Conta: '+nameAccountLaunch);
        modal.find('#typeAccountDeleteModal').html('Tipo: '+typeAccountLaunch);
        modal.find('#idAccountLaunch').val(idAccountLaunch);
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

    $("#btn-save-type-account").click(function (e) { 
        e.preventDefault();
        var dataForm = {
            account_types_name: $('#account_types_name').val(),
            account_types_id_user: $('#account_types_id_user').val()
        };
        SearaAjax.post('tipo-conta', dataForm, function( response ){
            notify.response(response);
            $("#account_types_name").val('');
            setTimeout(function() {window.location.reload()}, 1500);
        })
        .fail(function(jqXHR){
            notify.response(jqXHR.responseJSON);
            console.log(jqXHR);
        })
        .always(function(){
            $("#modalSaveType").modal('hide');
            console.log('hideModal');

        });
        // SearaAjax.post('tipo-conta', dataForm, function( response ){
        //     notify.response(response);
        // });
    });
});
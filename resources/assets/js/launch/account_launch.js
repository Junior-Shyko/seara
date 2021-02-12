$(document).ready(function () {
    $("#btn-save-account-launch").click(function (e) { 
        e.preventDefault();
        var form = $("#form-account-launch").serialize();
        // $.ajax({
        //     type: "POST",
        //     url: SearaApp.baseURL+'launch/account/create',
        //     data: form,
        //     dataType: "JSON",
        //     success: function (response) {
        //         console.log(response)
        //         new PNotify({
        //             title: 'Sucesso',
        //             text: response.message,
        //             type: response.status,
        //             styling: 'bootstrap3'
        //         });
        //     }
        // }).fail(function(error) {
        //     console.log(error)
        //     new PNotify({
        //         title: 'ops!',
        //         text: error.responseJSON.message,
        //         type: 'error',
        //         styling: 'bootstrap3'
        //     });
        // });
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
$(document).ready(function () {
    //$("#modal-entry").modal('show');
    $("#lancar_conta").modal('show');
    
    $("#cod_account").change(function(event) {
    	/* Act on the event */
    var codAccount = $("#cod_account").val();
    console.log({codAccount});	
	    $.get(SearaApp.baseURL+'/launch/account/search/'+codAccount, function(data) {
	    	/*optional stuff to do after success */
            console.log(data);
            $("#label_desc_type").html(data.accountlaunch_type);
            $("#entries_description").val(data.accountlaunch_history);
	    });
    });
    $('#cod_account').select2({
      placeholder: 'Escolha a conta',
      allowClear: true
    });
});
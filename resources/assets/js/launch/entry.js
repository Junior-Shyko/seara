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
	    });
    });
});
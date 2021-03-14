$(document).ready(function () {
    //$("#modal-entry").modal('show');
    $("#lancar_conta").modal('show');
    
    jquery.blur(function(event) {
    	/* Act on the event */
    var codAccount = $("#cod_account").val();
    console.log({codAccount});	
    });
});
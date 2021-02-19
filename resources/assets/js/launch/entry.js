$(document).ready(function () {
    //$("#modal-entry").modal('show');
    $("#lancar_conta").modal('show');
    hideDivs();
    $('#entries_decimate').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#box_offer').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#entries_other').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#entries_end').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $("#cod_account").change(function(event) {
    hideDivs();   
    	/* Act on the event */
    var codAccount = $("#cod_account").val();
    console.log({codAccount});	
	    $.get(SearaApp.baseURL+'/launch/account/search/'+codAccount, function(data) {
	    	/*optional stuff to do after success */
            console.log(data[0]);
            $("#label_desc_type").html(data[0].account_types_name);
            $("#entries_description").val(data[0].accountlaunch_history);
            $("#account_launches_referring").html(data[0].account_launches_referring);
            switch(data[0].account_launches_referring) {
                case 'Dizimo':
                    $("#divEntradas").show();
                    $("#diventries_decimate").show();
                    break;
                case 'Ofertas':
                    $("#divEntradas").show();
                    $("#divbox_offer").show();
                    break;
                case 'Outros':
                    $("#divEntradas").show();
                    $("#diventries_other").show();
                    break;
            }
            if(data[0].account_types_name == 'Despesa') {
                hideDivs(); 
                $("#idSaida").show();
                $("#diventries_end").show();
            }

	    });
    });
    $('#cod_account').select2({
      placeholder: 'Escolha a conta',
      allowClear: true
    });
});

function hideDivs() {
    $("#diventries_decimate").hide();
    $("#divbox_offer").hide();
    $("#diventries_other").hide();
    $("#diventries_end").hide();
    $("#divEntradas").hide();
    $("#idSaida").hide();
}
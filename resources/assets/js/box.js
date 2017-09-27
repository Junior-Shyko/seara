$(document).ready(function() {
$('#alter_entries_decimate').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#alter_entries_offer').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#alter_entries_other').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#alter_entries_end').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    
}); 

function reloadTable()
{
	$("#table_launch").DataTable().ajax.reload();
}

function delete_launch(id){
	token_delete_launch  =  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
	$("#modal_delete_launch").modal('show');
	$("#btn-conf-delete-launch").click(function(){
		$.ajax({
			url: 'caixa/delete',
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {entries_id: id},
			success:function(response){
				reloadTable();
                new PNotify({
                    title: 'Excluído',
                    text: 'Lançamento Excluído com sucesso',
                    type: 'success',
                    styling: 'bootstrap3'
                });
				$("#modal_delete_launch").modal('hide');
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});




	});
}

$('#entries_decimate').mask('000.000.000.000.000,00', {reverse: true});
$('#box_offer').mask('000.000.000.000.000,00', {reverse: true});
$('#entries_other').mask('000.000.000.000.000,00', {reverse: true});
$('#entries_end').mask('000.000.000.000.000,00', {reverse: true});
//MODAL DE ALTERAR AS ENTRADAS


$(function() {
    //MASCARA DE MONEY
    $('#boxies_balance_initial_modal').maskMoney(
    	{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    	);
    
    
    var route       = url_project + '/conta';
    var route_box   = url_project + '/caixa';
    var token  =  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
    $("#save_account").click(function(event) {
    	/* Act on the event */
    	
    	name_account                = $("#accounts_name").val();
    	id_type_account             = $("#accounts_id_type_account").val(); 
    	id_user_save_account        = id_user;
        id_company_save_account     = id_company;
    	console.log(id_type_account);
    	$.ajax({
    		url: route,
    		type: 'POST',
    		data: {accounts_name: name_account , accounts_id_user: id_user, accounts_id_company: id_company, accounts_id_type_account: id_type_account },
    		
    		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
    		dataType: 'JSON',
    		success: function(){
    			new PNotify({
    				title: 'Cadastrado',
    				text: 'Conta Registrada com sucesso',
    				type: 'success',
    				styling: 'bootstrap3'
    			});
    			$('#accounts_name').val('');
    		}    		
    	})
    	.done(function() {
    		console.log("success");
    	})
    	.fail(function() {
    		console.log("error");
    	})
    	.always(function() {
    		console.log("complete");
    	});
    });
    
    
    $("#cod_account").blur(function(event) {
    	/* Act on the event */
    	code_account = $("#cod_account").val();
    	route_get_account = url_project + '/conta';
    	$.get( route_get_account+'/'+code_account, function( data ) {
    		$( "#label_desc_account" ).html( data[0][0].accounts_name);
    		nome_tipo_conta = data[0][0].type_accounts_name.toUpperCase();
    		$( "#label_desc_type" ).html( "Tipo de conta: " + nome_tipo_conta);
    		if(nome_tipo_conta == "ENTRADA"){
                $("#entries_end").attr('disabled','disabled');
            }
    		$( "#boxes_description" ).val( data[0][0].accounts_name);                  
    	});
    	
    });
    
        //SUBMIT DO FORM
        $("#save_entry").click(function(){
        	console.log($('form#form_entry').serializeObject());
        	$.ajax({
        		url: route_box,
        		type: 'POST',
        		dataType: 'json',
        		headers: token,
        		data: $('form#form_entry').serializeObject(),
        		success:function(){
        			new PNotify({
        				title: 'Cadastrado',
        				text: 'Seu lançamento foi realizado com sucesso',
        				type: 'success',
        				styling: 'bootstrap3'
        			});
        			$('form#form_entry')[0].reset();
        			$("#cod_account").focus();
        			reloadTable();
        		}
        	})
        	.done(function() {
        		console.log("success");
        	})
        	.fail(function() {
        		console.log("error");
        		new PNotify({
        			title: 'Erro',
        			text: 'Ocorreu um erro, tente novamente',
        			type: 'danger',
        			styling: 'bootstrap3'
        		});
        	})
        	.always(function() {
        		console.log("complete");
        	});
        	

        });


        

    });

$(document).ready(function() {
	$("#date_box_open").daterangepicker({
		singleDatePicker: true,
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true
	});

    $("#edit_entry").click(function(event){
                alert('modal de editar' + event);
            });

    
});

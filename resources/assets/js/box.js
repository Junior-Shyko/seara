$(document).ready(function() {

	$('#table_launch').DataTable({

		ajax: {
			url:  url_project + '/caixa/show',
			dataSrc: ''

		},
		columns: [  
		{ data: 'entries_day', name: 'entries_day' },
		{ data: 'entries_description', name: 'entries_description' },
		{ data: 'entries_decimate', name: 'entries_decimate' },
		{ data: 'entries_offer', name: 'entries_offer' },
		{ data: 'entries_other', name: 'entries_other' },
		{ data: 'entries_end', name: 'entries_end' },
		{
			data: "entries_id",
			bSortable: false,
			mRender: function (data) { return '<a href="#" class="btn btn-info" ><i class="fa fa-pencil" style="font-size: 12px;" data-original-title="Alterar"></i></a> <a href="#" class="btn btn-danger" onclick="delete_launch('+data+')" ><i class="fa fa-trash" style="font-size: 12px;" title="Excluir"></i></a>'; }
		}
		],

		language: {
			"lengthMenu": "Exibir _MENU_ recibos por página",
			"zeroRecords": "Nenhum recibo cadastrado para essa pesquisa",
			"infoEmpty": "Exibindo 0 de 0 recibos",
			"emptyTable": "Nenhum recibo cadastrado",
			"info": "Exibindo página _PAGE_ de _PAGES_",
			"infoFiltered": "(filtrados de _MAX_ recibos)",
			"search": "Pesquisar:",
			"paginate": {
				"previous": "Anterior",
				"next": "Próximo",
				"first": "Primeiro",
				"last": "Último"
			}
		},
	}); 
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
			data: {boxes_id: id},
			success:function(response){
				reloadTable();
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
});

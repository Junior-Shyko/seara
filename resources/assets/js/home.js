var companyTable;

$(document).ready(function(){
	console.log('home')
	// var colunas = [
	//   { data: 'company_name', name: 'company_name' },
	//   { data: 'company_fantasy', name: 'company_fantasy' },
	//   { data: 'company_admin', name: 'company_admin' },
	//   { data: 'company_cnpj', name: 'company_cnpj' },
	//   { data: 'created_at', name: 'created_at' },
	//   { data: 'action', name: 'action', orderable: false, searchable: false }
	// ];
	//
	// companyTable = new SearaTable('company-table', 'datatable', colunas);
	//
	// console.log( companyTable );
	//
	// companyTable.loadTable();
});

function allowCompany ( companyID )
{
	swal({
		title: 'Ativar empresa',
		text: 'Você tem certeza que quer ativar esta empresa?',
		showCancelButton: true,
		type: 'warning'
	})
	.then(function(){

		SearaLoader.showModal('Ativando empresa...');
		SearaAjax.post('companies/alterar-status', {company_id: companyID}, function( response ){
			notify.response(response);
			companyTable.reloadTable();
		})
		.fail(function(jqXHR){
			notify.response(jqXHR.responseJSON);
		})
		.always(function(){
			SearaLoader.hideModal();
		});

	});

	
}
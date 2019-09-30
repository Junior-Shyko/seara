let CustomerModule = (function () {
    let companyResource = new ResourceModel('companies');
    let colunas = [
        { data: 'company_name', name: 'company_name' },
        { data: 'company_fantasy', name: 'company_fantasy' },
        { data: 'company_cnpj', name: 'company_cnpj' },
        { data: 'company_manager', name: 'company_manager' },
        { data: 'created_at', name: 'created_at', className: 'nowrap' },
        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'nowrap' }
    ];
    let companyTable = new SearaTable('company-table', 'companies/dataTable', colunas, 'cliente', 'clientes');

    function index () {
        companyTable.loadTable();

        $('#form-save-btn').on('click', function () {
            let companyId = $('#company-id').val();
            updateCompany(companyId);
        });
    }

    function deactivateCompany(id) {
        swal({
            title: 'Atenção',
            text: 'A empresa será desativada, deseja continuar?',
            type: 'warning',
            showCancelButton: true
        }).then(function() {
            SearaLoader.showModal('Desativando empresa...');
            var company = new ResourceModel('companies');

            company.delete(id, function (response) {
                notify.response(response);
                companyTable.reloadTable();
            }).fail(function (jqXHR) {
                notify.response(jqXHR.responseJSON);
            }).always(function(){
                SearaLoader.hideModal();
            });
        });
    }

    function editCompany (id) {
        $('#company-id').val(id);
        SearaLoader.showModal("Carregando dados da empresa...");
        companyResource.read(id, function (data) {
            populateForm('#form-customer', data);
            $('#modal-customer').modal('show');
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }

    function updateCompany(companyId) {
        let data = packForm('#form-customer');
        SearaLoader.showModal("Atualizando empresa...");
        companyResource.update(companyId, data)
            .then(function (response) {
                notify.response(response);
                $('#modal-customer').modal('hide');
                companyTable.reloadTable();
            })
            .fail(function (jqXHR) {
                notify.response(jqXHR.responseJSON);
            })
            .always(function () {
                SearaLoader.hideModal();
            });
    }

    return {
        index: index,
        editCompany: editCompany,
        deactivateCompany: deactivateCompany
    };
})();

$(document).ready(function(){
    CustomerModule.index();
});

function deactivateCompany(id) {
    CustomerModule.deactivateCompany(id);
}

function editCompany(id) {
    CustomerModule.editCompany(id);
}
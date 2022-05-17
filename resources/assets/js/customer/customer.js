let CustomerModule = (function () {
//import { get } from '../../../../vendor/bower_components/gentelella/vendors/moment/src/lib/duration/get';

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

    function modalLogin(id) {
       //client = SearaAjax.get( 'companies/info/' + id );
        $("#codCompany").val(id);
        console.log(SearaApp.baseURL);
        $.get(SearaApp.baseURL + 'companies/info/' + id ,
            function (data, textStatus, jqXHR) {
                console.log(data);
                $("#divAlterUserAccess").hide();
                if(data.length > 0) {
                    $("#divAlterUserAccess").show();
                    $("#btnAlterUserAccess").attr('href', SearaApp.baseURL +'users/'+ btoa(id) +'/edit');
                }
                //$("#codCompany").val(data.id);
            }
        );
        $("#modalAcessClient").modal('show');
    }

    function redirectBoxCompany(id) {
        window.location.href=SearaApp.baseURL+'lancar?company='+id;
    }

    return {
        index: index,
        editCompany: editCompany,
        deactivateCompany: deactivateCompany,
        modalLogin: modalLogin,
        redirectBoxCompany: redirectBoxCompany
    };
})();

$(document).ready(function(){
    CustomerModule.index();
    $("#btnSaveUser").click(function (e) { 
        e.preventDefault();
        var form = $("#formAccessUser").serialize();
        console.log({form});
        $.ajax({
            type: "post",
            url: SearaApp.baseURL + 'api/create-user',
            data: form,
            dataType: "json",
            success: function (response) {
                SearaAlert.success(response.message);
                $("#modalAcessClient").modal('hide');
            }
        });
    });
});

function deactivateCompany(id) {
    CustomerModule.deactivateCompany(id);
}

function editCompany(id) {
    CustomerModule.editCompany(id);
}

function modalLogin(id) {
    CustomerModule.modalLogin(id);
}

function redirectBoxCompany(id) {
    CustomerModule.redirectBoxCompany(id);
}
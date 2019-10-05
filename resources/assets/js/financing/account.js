let AccountModule = (function () {
    let accountResource = new ResourceModel('conta');
    let $modalAccount = $('#modal-account');
    let columns = [
        {data: 'name', name: 'name'},
        {data: 'type', name: 'type'},
        {data: 'balance', name: 'balance'},
        {data: 'created_at', name: 'created_at'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'nowrap'},
    ];
    let accountTable = new SearaTable('account-table', 'conta/dataTable', columns, 'conta', 'contas');

    function index () {
        accountTable.loadTable();

        $('#create-account-btn').on('click', function () {
            $modalAccount.modal('show');
        });

        $('#form-save-btn').on('click', createAccount);
    }

    function createAccount() {
        let formData = packForm('#form-account');
        SearaLoader.showModal('Cadastrando conta...');

        accountResource.create(formData, function (response) {
            notify.response(response);
            $modalAccount.modal('hide');
            accountTable.reloadTable();
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }

    function archiveAccount(id) {
        swal({
            title: 'Atenção',
            text: 'A conta será arquivada, deseja continuar?',
            type: 'warning',
            showCancelButton: true
        }).then(function() {
            SearaLoader.showModal('Arquivando conta...');
            accountResource.delete(id, function (response) {
                notify.response(response);
                accountTable.reloadTable();
            }).fail(function (jqXHR) {
                notify.response(jqXHR.responseJSON);
            }).always(function(){
                SearaLoader.hideModal();
            });
        });
    }

    return {
        index: index,
        archiveAccount: archiveAccount
    };
})();

$(document).ready(function () {
    AccountModule.index();
});

function archiveAccount(id) {
    AccountModule.archiveAccount(id);
}

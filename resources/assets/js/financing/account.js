let AccountModule = (function () {
    let accountResource = new ResourceModel('conta');
    let $modalAccount = $('#modal-account');
    let columns = [
        {data: 'name', name: 'name'},
        {data: 'type', name: 'type'},
        {data: 'balance', name: 'balance'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'nowrap'},
    ];
    let accountTable = new SearaTable('account-table', 'conta/dataTable', columns, 'conta', 'contas');
    let accountId = $('#account-id');

    function index () {
        accountTable.loadTable();

        $('#create-account-btn').on('click', function () {
            showForm();
        });

        $('#form-save-btn').on('click', function () {
            let id = accountId.val();

            if ('' === id) {
                createAccount();
                return;
            }

            updateAccount(id);
        });
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

    function editAccount(id) {
        SearaLoader.showModal("Carregando dados da conta...");
        accountResource.read(id, function (data) {
            showForm();
            populateForm('#form-account', data);
            accountId.val(id);
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }

    function updateAccount(id) {
        let formData = packForm('#form-account');
        SearaLoader.showModal('Cadastrando conta...');

        accountResource.update(id, formData, function (response) {
            notify.response(response);
            closeForm();
            accountTable.reloadTable();
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }

    function showForm() {
        accountId.val('');
        $('#form-account').trigger('reset');
        $modalAccount.modal('show');
    }

    function closeForm() {
        $modalAccount.modal('hide');
    }

    return {
        index: index,
        archiveAccount: archiveAccount,
        editAccount: editAccount
    };
})();

$(document).ready(function () {
    AccountModule.index();
});

function archiveAccount(id) {
    AccountModule.archiveAccount(id);
}

function editAccount(id) {
    AccountModule.editAccount(id);
}

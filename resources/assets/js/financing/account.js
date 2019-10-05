let AccountModule = (function () {
    let accountResource = new ResourceModel('conta');
    let $modalAccount = $('#modal-account');

    function index () {
        $('#create-account-btn').on('click', function () {
            $modalAccount.modal('show');
        });

        $('#form-save-btn').on('click', function () {
            let formData = packForm('#form-account');
            SearaLoader.showModal('Cadastrando conta...');

            accountResource.create(formData, function (response) {
                notify.response(response);
                $modalAccount.modal('hide');
            }).fail(function (jqXHR) {
                notify.response(jqXHR.responseJSON);
            }).always(function () {
                SearaLoader.hideModal();
            });
        });
    }

    return {
        index: index
    };
})();

$(document).ready(function () {
    AccountModule.index();
});

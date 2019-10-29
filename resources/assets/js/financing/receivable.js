let ReceivableModule = (function () {
    const columns = [
        {data: 'due_date', name: 'due_date'},
        {data: 'payment_date', name: 'payment_date', className: 'nowrap'},
        {data: 'description', name: 'description'},
        {data: 'category', name: 'category'},
        {data: 'account', name: 'account'},
        {data: 'amount', name: 'amount'},
        {data: 'manager', name: 'manager'},
        {data: 'customer', name: 'customer'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'action'},
    ];

    const crud = new Crud(
        'receivable',
        'conta a receber',
        'contas a receber',
        columns
    );

    function index() {
        crud.initialize();
        $('#modal-receivable').on('hidden.bs.modal', function () {
            $('#repeat_for').closest('div').show();
        });
    }

    function deleteReceivable(id) {
        crud.destroyResource(id, 'Essa conta a receber será removida e não pode ser desfeito, deseja continuar?');
    }

    function editReceivable(id) {
        $('#repeat_for').closest('div').hide();
        crud.editResource(id);
    }

    function payReceivable(id) {
        $('#modal-pay-receivable').modal('show');
        $('#payment_date').val(formattedCurrentDate);
        reloadAllMasks();

        $('#form-pay-receivable').off('submit');
        $('#form-pay-receivable').on('submit', function () {
            SearaLoader.showModal('Efetivando conta...');
            SearaAjax.put('/receivable/payment/' + id, {
                payment_date: $('#payment_date').val()
            })
                .then(function (response) {
                    notify.response(response);
                    $('#modal-pay-receivable').modal('hide');
                    reloadTable('table-receivable');
                })
                .fail(function (jqXHR) {
                    notify.response(jqXHR.responseJSON);
                })
                .always(function () {
                    SearaLoader.hideModal();
                })
        });
    }

    function generateReceipt(id) {
        swal({
            title: 'Geração de Recibo',
            text: 'Um novo recibo com as informações dessa conta será gerado, deseja continuar?',
            type: 'warning',
            showCancelButton: true
        }).then(function() {
            SearaLoader.showModal('Gerando Recibo ...');
            SearaAjax.put('/receivable/' + id + '/receipt', {}, function (response) {
                notify.response(response);
                window.open(response.location,'_blank');
            }).fail(function (jqXHR) {
                notify.response(jqXHR.responseJSON);
            }).always(function(){
                SearaLoader.hideModal();
            });
        });
    }

    return {
        index,
        deleteReceivable,
        editReceivable,
        payReceivable,
        generateReceipt
    };
})();

$(() => {
    ReceivableModule.index();
});

function deleteReceivable(id) {
    ReceivableModule.deleteReceivable(id);
}

function editReceivable(id) {
    ReceivableModule.editReceivable(id);
}

function payReceivable(id) {
    ReceivableModule.payReceivable(id);
}

function generateReceipt(id) {
    ReceivableModule.generateReceipt(id);
}

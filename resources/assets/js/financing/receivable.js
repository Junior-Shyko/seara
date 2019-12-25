let ReceivableModule = (function () {
    const columns = [
        {data: 'due_date', name: 'due_date'},
        {data: 'payment_date', name: 'payment_date', className: 'nowrap'},
        {data: 'description', name: 'description'},
        {data: 'category', name: 'category'},
        {data: 'account', name: 'account'},
        {data: 'amount', name: 'amount', className: 'formatted_number'},
        {data: 'paid_amount', name: 'paid_amount', className: 'formatted_number'},
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

    function updateDebtReliefAmount() {
        let amount = convertBrCoinToFloat($('#pay-receivable-amount').val());
        let lateFeeAmount = convertBrCoinToFloat(
            $('#pay-receivable-late-fee-amount').val()
        );

        let debtReliefAmount = amount - lateFeeAmount;

        populatePayReceivableForm({
            debt_relief_amount: formatFloatToBrCoin(debtReliefAmount)
        });
    }

    function index() {
        crud.initialize();
        $('#modal-receivable').on('hidden.bs.modal', function () {
            $('#repeat_for').closest('div').show();
        });

    }

    function registerAmountEvents(remainingAmount) {
        $('#pay-receivable-amount').off('change');
        $('#pay-receivable-late-fee-amount').off('change');

        $('#pay-receivable-amount').on('change', () => {
            let totalAmount = convertBrCoinToFloat(
                $('#pay-receivable-amount').val()
            );

            let differenceToTheRemainingAmount = totalAmount - remainingAmount;
            if (differenceToTheRemainingAmount > 0) {
                populatePayReceivableForm({
                    late_fee_amount: formatFloatToBrCoin(differenceToTheRemainingAmount)
                });
            }

            updateDebtReliefAmount();
        });
        $("#pay-receivable-late-fee-amount").on('change', updateDebtReliefAmount);
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
        let remainingAmount = $('#receivable-' + id).data('remainingAmount');
        let data = {
            payment_date: formattedCurrentDate(),
            amount: remainingAmount,
            debt_relief_amount: remainingAmount,
            late_fee_amount: "0,00"
        };
        populateForm('#form-pay-receivable', data);
        reloadAllMasks();
        registerAmountEvents(convertBrCoinToFloat(remainingAmount));

        $('#form-pay-receivable').off('submit');
        $('#form-pay-receivable').on('submit', function () {
            if (!$('#form-pay-receivable').parsley().validate()) {
                return;
            }

            SearaLoader.showModal('Efetivando conta...');
            let data = packForm('#form-pay-receivable');
            data.remaining_amount = remainingAmount;

            SearaAjax.put('/receivable/payment/' + id, data)
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

    function populatePayReceivableForm(data) {
        populateForm('#form-pay-receivable', data);
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

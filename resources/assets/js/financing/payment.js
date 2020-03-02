let PaymentModule = (function () {
    const columns = [
        {data: 'company_manager', name: 'company_manager'},
        {data: 'customer', name: 'customer'},
        {data: 'payment_date', name: 'payment_date'},
        {data: 'created_at', name: 'created_at'},
        {data: 'amount', name: 'amount', className: 'formatted_number'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ];
    const crud = new Crud(
        'payment',
        'pagamento',
        'pagamentos',
        columns
    );

    function index() {
        crud.initialize();
    }

    function deletePayment(id) {
        crud.destroyResource(id, 'Deseja excluir esse pagamento?')
    }

    function editPayment(id) {
        crud.editResource(id);
    }

    return {
        index: index,
        deletePayment: deletePayment,
        editPayment: editPayment
    };
})();

$(() => {
    PaymentModule.index();
});

function deletePayment(id) {
    PaymentModule.deletePayment(id);
}

function editPayment(id) {
    PaymentModule.editPayment(id);
}

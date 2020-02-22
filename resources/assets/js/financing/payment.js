let PaymentModule = (function () {
    const columns = [
        {data: 'company_manager', name: 'company_manager'},
        {data: 'customer', name: 'customer'},
        {data: 'payment_date', name: 'payment_date'},
        {data: 'created_at', name: 'created_at'},
        {data: 'amount', name: 'amount'},
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

    return {
        index: index,
    };
})();

$(() => {
    PaymentModule.index();
});


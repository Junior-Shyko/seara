let ReceivableModule = (function () {
    const columns = [
        {data: 'due_date', name: 'due_date'},
        {data: 'payment_date', name: 'payment_date'},
        {data: 'description', name: 'description'},
        {data: 'category', name: 'category'},
        {data: 'account', name: 'account'},
        {data: 'amount', name: 'amount'},
        {data: 'customer', name: 'customer'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ];

    const crud = new Crud(
        'receivable',
        'conta a receber',
        'contas a receber',
        columns
    );

    function index() {
        crud.initialize();
    }

    function deleteReceivable(id) {
        crud.destroyResource(id, 'Essa conta a receber será removida e não pode ser desfeito, deseja continuar?');
    }

    return {
        index,
        deleteReceivable
    };
})();

$(() => {
    ReceivableModule.index();
});

function deleteReceivable(id) {
    ReceivableModule.deleteReceivable(id);
}

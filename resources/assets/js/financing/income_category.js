let IncomeCategoryModule = (function () {
    const columns = [
        {data: 'name', name: 'name'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ];
    const crud = new Crud(
        'income-category',
        'categoria de receita',
        'categorias de receita',
        columns
    );

    function index() {
        crud.initialize();
    }

    function editIncomeCategory(id) {
        crud.editResource(id);
    }

    function archiveIncomeCategory(id) {
        crud.destroyResource(id, 'A categoria sera arquivada, deseja continuar?');
    }

    return {
        index: index,
        editIncomeCategory: editIncomeCategory,
        archiveIncomeCategory: archiveIncomeCategory
    };
})();

$(() => {
    IncomeCategoryModule.index();
});

function editIncomeCategory(id) {
    IncomeCategoryModule.editIncomeCategory(id);
}

function archiveIncomeCategory(id) {
    IncomeCategoryModule.archiveIncomeCategory(id);
}

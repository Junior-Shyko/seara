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

    return {
        index: index,
    };
})();

$(() => {
    IncomeCategoryModule.index();
});

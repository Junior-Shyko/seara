class Crud {
    constructor(resourceName, singularName, pluralName, dataTableColumns) {
        this.singularName = singularName;
        this.resourceModel = new ResourceModel(resourceName);
        this.formSel = '#form-' + resourceName;
        this.$resourceModal = $('#modal-' + resourceName);
        this.$createBtn = $('#create-' + resourceName + '-btn');
        this.$submitBtn = $('#form-save-' + resourceName + '-btn');
        this.$resourceId = $('#' + resourceName + '-id');
        this.$form = $(this.formSel);
        this.resourceTable = new SearaTable(
            'table-' + resourceName,
            resourceName + '/dataTable',
            dataTableColumns,
            singularName,
            pluralName
        );
    }

    initialize() {
        this.resourceTable.loadTable();
        this.$createBtn.on('click', () => {
            this._showForm();
        });

        this.$submitBtn.on('click', () => {
            let id = this.$resourceId.val();

            if ('' === id) {
                this._storeResource();
                return;
            }

            this._updateAccount(id);
        });
    }

    editResource(id) {
        SearaLoader.showModal("Carregando dados...");
        const thisCrud = this;
        this.resourceModel.read(id, function (data) {
            thisCrud._showForm();
            populateForm(thisCrud.formSel, data);
            thisCrud.$resourceId.val(id);
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }

    destroyResource(id, confirmationText) {
        const thisCrud = this;
        swal({
            title: 'Atenção',
            text: confirmationText,
            type: 'warning',
            showCancelButton: true
        }).then(function() {
            SearaLoader.showModal('Aguarde ...');
            thisCrud.resourceModel.delete(id, function (response) {
                notify.response(response);
                thisCrud.resourceTable.reloadTable();
            }).fail(function (jqXHR) {
                notify.response(jqXHR.responseJSON);
            }).always(function(){
                SearaLoader.hideModal();
            });
        });
    }

    _showForm() {
        this.$resourceId.val('');
        this.$form.trigger('reset');
        this.$resourceModal.modal('show');
    }

    _closeForm() {
        this.$resourceModal.modal('hide');
    }

    _storeResource() {
        let formData = packForm(this.formSel);
        SearaLoader.showModal('Cadastrando ' + this.singularName + ' ...');

        const thisCrud = this;
        this.resourceModel.create(formData, function (response) {
            notify.response(response);
            thisCrud._closeForm();
            thisCrud.resourceTable.reloadTable();
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }

    _updateAccount(id) {
        let formData = packForm(this.formSel);
        SearaLoader.showModal('Atualizando ' + this.singularName + ' ...');

        const thisCrud = this;
        this.resourceModel.update(id, formData, function (response) {
            notify.response(response);
            thisCrud._closeForm();
            thisCrud.resourceTable.reloadTable();
        }).fail(function (jqXHR) {
            notify.response(jqXHR.responseJSON);
        }).always(function () {
            SearaLoader.hideModal();
        });
    }
}

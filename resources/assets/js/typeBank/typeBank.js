$(document).ready(function () {
    var table = $('#table-type-bank').DataTable( {
        ajax: SearaApp.baseURL+'tipo-banco/getType',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', searchable: false, className: 'nowrap'}
        ]
    } );
});

$("#nameButtonTypeBank").click(function (e) { 
    e.preventDefault();
    var inputTypeBank = $("#inputTypeBank").val();
    console.log({inputTypeBank});
    $.ajax({
        url: SearaApp.baseURL+'tipo-banco',
        type: 'POST',
        dataType: 'json',
        data: {name: inputTypeBank},
        success:function(response){
            console.log(response);
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: response.type,
                styling: 'bootstrap3',
                icon: 'fa fa-check'
            });
            $("#inputTypeBank").val('');
            $("#table-type-bank").DataTable().ajax.reload();
        }
    })
    .fail(function() {
        new PNotify({
            title: 'Ops!!!',
            text: response.message,
            type: response.type,
            styling: 'bootstrap3',
            icon: 'fa fa-check'
        });
    })
    .always(function() {
        console.log("complete");
    });
});

//EDITAR TIPO BANCARIO
function editTypeBank(id) {
    $.getJSON(SearaApp.baseURL+'tipo-banco/'+id,
        function (data, textStatus, jqXHR) {
            $("#inputTypeBank").val(data.name);
            $("#idTypeBank").val(data.id);
            $("#nameButtonTypeBank").text('Alterar');
            $("#typeActionBank").val('update');
            $("#inputTypeBank").addClass('border-update');
        }
    );
}

//PASSANDO DADOS PARA O COMPONENTE DE MODAL
$('#modalDeleteTypeAccontBank').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idBank = button.data('id')
    var modal = $(this)
    modal.find('#delete_type_account_bank').val(idBank);
    // modal.find('.modal-body input').val(recipient)
})

$("#btn_delete_type_account_bank").click(function (e) { 
    e.preventDefault();
    var idBank = $('#delete_type_account_bank').val();
    $.ajax({
        type: "DELETE",
        url: SearaApp.baseURL+'tipo-banco/'+idBank,
        dataType: "json"
    })
    .done(function(response) {
        console.log("success");
        new PNotify({
            title: 'Sucesso',
            text: response.message,
            type: response.type,
            styling: 'bootstrap3',
            icon: 'fa fa-check'
        });
        $("#table-type-bank").DataTable().ajax.reload();
        $("#modalDeleteTypeAccontBank").modal('hide');
    })
    .fail(function(response) {
        new PNotify({
            title: 'Ops!',
            text: response.message,
            type: response.type,
            styling: 'bootstrap3',
            icon: 'fa fa-exclamation-triangle'
        });
    })
    .always(function() {
        console.log("complete");
    });
});
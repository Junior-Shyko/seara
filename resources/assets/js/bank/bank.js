$(document).ready(function () {
    var table = $('#table-bank').DataTable( {
        ajax: SearaApp.baseURL+'banco/getBank',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', searchable: false, className: 'nowrap'}
        ]
    } );
});

$("#btnPlusBank").click(function (e) { 
    e.preventDefault();
    var inputBank = $("#inputBank").val();
    console.log({inputBank});
    $.ajax({
        url: SearaApp.baseURL+'banco',
        type: 'POST',
        dataType: 'json',
        data: {name: inputBank},
        success:function(response){
            console.log(response);
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: response.type,
                styling: 'bootstrap3',
                icon: 'fa fa-check'
            });
            $("#inputBank").val('');
            $("#table-bank").DataTable().ajax.reload();
        }
    })
    .done(function() {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
});

function editBank(id) {
    console.log({id})
    $.getJSON(SearaApp.baseURL+'getBank/'+id,
        function (data, textStatus, jqXHR) {
            $("#inputBank").val(data.name);
            $("#id_bank").val(data.id);
            $("#nameButtonBank").text('Alterar');
            $("#typeActionBank").val('update');
            $("#inputBank").addClass('border-update');
        }
    );
    
}
//PASSANDO DADOS PARA O COMPONENTE DE MODAL
$('#modalDeleteBank').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idBank = button.data('id')
    var modal = $(this)
    modal.find('#delete_bank').val(idBank);
    // modal.find('.modal-body input').val(recipient)
})

$("#btnDeleteBank").click(function (e) { 
    e.preventDefault();
    var idBank = $('#delete_bank').val();
    $.ajax({
        type: "DELTE",
        url: SearaApp.baseURL+'banco',
        data: {id : idBank},
        dataType: "json",
        success: function (response) {
            console.log(response)
        }
    });
});
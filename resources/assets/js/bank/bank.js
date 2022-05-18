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
$(document).ready(function () {
    
    var idCodeCompany = $("#idCodeCompany").val();

    var table = $('#table-type-bank').DataTable( {
        ajax: SearaApp.baseURL+'tipo-banco/getType',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', searchable: false, className: 'nowrap'}
        ]
    } );

    //Contas bancarias
    $('#table-account-bank').DataTable( {
        ajax: SearaApp.baseURL+'todasContas/'+idCodeCompany+'/',
        columns: [
            {data: 'nameBank', name: 'nameBank'},
            {data: 'nameTypeBank', name: 'nameTypeBank'},
            {data: 'number', name: 'number'},
            {data: 'agency_number', name: 'agency_number'},
            {data: 'action', name: 'action', searchable: false, className: 'nowrap'}
        ]
    } );

    $('.valueAccontBank').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
});

$("#nameButtonTypeBank").click(function (e) { 
    e.preventDefault();
    var inputTypeBank = $("#inputTypeBank").val();
    var idTypebaNk = $("#idTypeBank").val();
    var formData = {
        name: inputTypeBank,
        idTypeBank: idTypebaNk
    };
    $.ajax({
        url: SearaApp.baseURL+'tipo-banco',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success:function(response){
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: response.type,
                styling: 'bootstrap3',
                icon: 'fa fa-check'
            });
            $("#inputTypeBank").val('');
            $("#idTypeBank").val('');
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
            $("#titleButtonTypeBank").text('Alterar');
            $("#typeActionBank").val('update');
            $("#inputTypeBank").addClass('border-update');
        }
    );
}
//EDIÇÃO DE CONTA BANCARIA
function editAccountBank(id){
    $.getJSON(SearaApp.baseURL+'conta-bancaria/'+id+'/',
        function (data, textStatus, jqXHR) {
            //formatando formulario para edição
            $(".valueAccontBank").addClass('border-update');
            $(".valueAccontBank").val(data.balance);
            $(".accountBankNumber").addClass('border-update');
            $(".accountBankNumber").val(data.number);
            $(".agency_number").addClass('border-update');
            $(".agency_number").val(data.agency_number);
            $(".bank_id").addClass('border-update');
            $(".bank_id").val(data.bank_id).trigger('change');
            $(".selectTypeAccountBank").addClass('border-update');
            $(".selectTypeAccountBank").val(data.typeBank_id).trigger('change');
            $("#idAccontBank").val(data.id);
            
        }
    );
}


function archiveAccount(id) {
    $("#modalDeleteAccountBank").modal('show');
    $('#delete_account_bank').val(id);
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

$("#btnSaveAccontBank").click(function (e){
    var form = $("#formAccountBank").serialize();
    console.log(form)
    //validação
    if(
        $(".accountBankNumber").val() == '' ||
        $(".agency_number").val() == '' ||
        $(".selectTypeAccountBank").val() == '' ||
        $(".bank_id").val() == ''
     ) {
        SearaAlert.error('Todos os campos são obrigatórios');
        return false;
    }
    var urlRequest = '';
    var typeRequest
    var idAccontBank = $("#idAccontBank").val();
    //referenciando url
    if(idAccontBank == '' ){
        typeRequest = "POST";
        urlRequest = SearaApp.baseURL + 'financial/account/store';
    }else{
        typeRequest = "PATCH";
        urlRequest = SearaApp.baseURL + 'financial/account/store/'+idAccontBank;
    }
    $.ajax({
        type: typeRequest,
        url: urlRequest,
        data: form,
        dataType: "json"
    })
    .done(function(response) {
        SearaAlert.success(response.message);
        $("#table-account-bank").DataTable().ajax.reload();
        $("#formAccountBank")[0].reset();
        $(".valueAccontBank").removeClass('border-update')
        $(".accountBankNumber").removeClass('border-update');
        $(".agency_number").removeClass('border-update');
    })
    .fail(function(response) {
        console.log(response);
        SearaAlert.success(response.message);
    });
});

//EXCLUINDO CONTA BANCARIA
$("#btnDeleteAccountBank").click(function (e) {
    e.preventDefault();
    var idAccountBank = $('#delete_account_bank').val();
    $.ajax({
        type: "DELETE",
        url: SearaApp.baseURL+'conta-bancaria/'+idAccountBank,
        dataType: "json"
    })
    .done(function(response) {
        SearaAlert.success(response.message);
        $("#table-account-bank").DataTable().ajax.reload();
        $("#modalDeleteAccountBank").modal('hide');
    })
    .fail(function(response) {
        SearaAlert.success(response.message);
    })
    .always(function() {
        console.log("complete");
    });
});


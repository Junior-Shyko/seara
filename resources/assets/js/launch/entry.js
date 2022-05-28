
$(document).ready(function () {
    $('#entries_value').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#realValueTranfer').maskMoney(
        {allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $("#lancar_conta").modal('show');
    //$("#dateRetroactive").hide();
    jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
        return this.flatten().reduce( function ( a, b ) {
            if ( typeof a === 'string' ) {
                a = a.replace(/[^\d.-]/g, '') * 1;
            }
            if ( typeof b === 'string' ) {
                b = b.replace(/[^\d.-]/g, '') * 1;
            }
     
            return a + b;
        }, 0 );
    } );

    Dropzone.autoDiscover = false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var idEntry = $("#idEntry").val();
    $("#form-upload-entry").dropzone({ 
        url: SearaApp.baseURL+"caixa/upload",
        params: idEntry,
        autoProcessQueue: true,
        dictDefaultMessage: "Arraste seus arquivos para essa área ou click para localizar",
        maxFiles: 4,
        dictMaxFilesExceeded: 'Você nao pode enviar mais arquivo',
        maxFilesize: 4,
        dictFileTooBig: 'O Arquivo excedeu o limite máximo permitido',
        clickable: true,
        uploadMultiple: true,
        addRemoveLinks: true,
        dictRemoveFile: 'Remover',
        acceptedFiles: 'image/*',
        headers: {
            'x-csrf-token': CSRF_TOKEN,
        },
        init: function () {
            this.on("success", function (_file, response) {
                notify.response(response);
            });
            this.on("error", function (file, error, _xhr) {
                console.log({file})
                console.log({error})
                console.log({hr})
            });
        }
    }); 
    //RETORNO DOS LANÇAMENTOS
    getLaunch();

    //valores do caixa banco
    bankBalance();
    internalBalance();
    general();
    $("#save_entry").click(function(){
        var form = $('form#form_entry').serialize();
        SearaAjax.post('lancar', form, function( response ){
            $("#lancar_conta").modal('hide');
            if(response.typeAccount == 'Despesa') {
                $("#modalUploadLaunch").modal('show');
            }
            $(".idEntry").val(response.id);
            $("#entry-table").DataTable().ajax.reload();
            bankBalance();
            internalBalance();
            general();
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: response.status,
                styling: 'bootstrap3'
            });
        })
        .fail(function(jqXHR){
            notify.response(jqXHR.responseJSON);

        })
        .always(function(){
            //console.log('hideModal');
        });
    });

    $('#modalDeleteComponent').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var launchName = button.data('name') 
        var type = button.data('type')
        var id = button.data('id')
        var modal = $(this)
        modal.find('#historyLaunchDeleteModal').text(launchName)
        modal.find('#typeLaunchDeleteModal').text(type)
        modal.find('#idDelete').val(id)
    })

    //ID DO LANÇAMENTO
        
    function getInfolaunch(id, nameDivFile) {
        $.get('info-launch/'+id,
        function (data, _textStatus, _jqXHR) { 
            $("#linkEdit").attr('href', SearaApp.baseURL+ 'lancar/' +data[0].entries_id+'/edit');
            var dt = dataAtualFormatada(data[0].createEntry);
            $(".day").html('Dia: '+dt);
            $(".his").html('Histórico: '+data[0].entries_description);
            $(".value").html('Valor: '+data[0].entries_value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
            $(".account").html('Conta: '+data[0].accountlaunch_name);
            $(".type").html('Dia: '+data[0].account_types_name);
            $(".per").html('Por: '+data[0].nameUser);
                $.each(data, function (_indexInArray, valueOfElement) { 
                    if(typeof valueOfElement.file_launches_name !== 'undefined'){
                        $("#"+nameDivFile).append('<div class="col-md-6 col-xs-12">'+
                        '<a href="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" class="thumbnail" data-lightbox="roadtrip" data-title="Conta: '+valueOfElement.entries_description+'"> <img src="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" '+'> </a>')

                        
                        // $("#filesEntriEdit").append('<div class="col-md-6 col-xs-12">'+
                        // '<a href="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" class="thumbnail" data-lightbox="roadtrip" data-title="Conta: '+valueOfElement.entries_description+'"> <img src="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" '+'> </a>')
                    }
                });
            }
        );
    }

    $('#modalInfoLaunch').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id');
        getInfolaunch(id, 'filesEntri');
    })
    $('#modalInfoLaunch').on('hidden.bs.modal', function (_e) {
        $("#filesEntri div").remove();
    })

    $("#cod_account").change(function(_event) {
    hideDivs();
    	/* Act on the event */
        var codAccount = $("#cod_account").val();
	    $.get(SearaApp.baseURL+'/launch/account/search/'+codAccount, function(data) {
	    	/*optional stuff to do after success */
            $("#label_desc_type").html(data[0].account_types_name);
            $("#entries_description").val(data[0].accountlaunch_history);
            $("#account_launches_referring").html(data[0].account_launches_referring);
            showDivs();
	    });
    });
    $('#cod_account').select2({
      placeholder: 'Escolha a conta',
      allowClear: true
    });
    //$.datetimepicker.setLocale('pt-BR');
    $('#dateRetroactive').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });
    $('#dateInitial').datetimepicker({
        timepicker:false,
        format:'d/m/Y',
        startDate:'-30d'
    });
    $('#dateEnd').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });
});

function getLaunch() {
    let colunas = [
        {data: 'entries_date_launch', name: 'entries_date_launch'},
        {data: 'entries_description', name: 'entries_description'},
        {data: 'entries_value', name: 'entries_value'},
        {data: 'entries_id_account', name: 'entries_id_account'},
        {data: 'entries_id_user', name: 'entries_id_user'},
        {data: 'action', name: 'action', searchable: false, className: 'nowrap'},
    ];
    var table = $('#entry-table').DataTable( {
        paging: false,
        retrieve: true,
        pageLength: 100
    } );
    table.destroy();
    table = $('#entry-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        ajax: SearaApp.baseURL+'all-launch',
        columns: colunas,
        drawCallback: function () {
            var api = this.api();
            var sum = 0;
            $( api.table().footer() ).html(
                sum = api.column( 2, {page:'current'} ).data().sum()
            );
          }
    });
    var table = $('#entry-table').DataTable();
    table
        .order(  [ 0, 'asc' ] )
        .draw();
}

function bankBalance() {
    $.ajax({
        type: "GET",
        url: SearaApp.baseURL + 'api/saldo-banco',
        dataType: "json",
        success: function (response) {
            var value = formatFloatToBrCoin(response)
            $("#bankBalance").html(value);
        }
    });
}

function internalBalance() {
    $.ajax({
        type: "GET",
        url: SearaApp.baseURL + 'api/saldo-interno',
        dataType: "json",
        success: function (response) {
            var value = formatFloatToBrCoin(response)
            $("#internalBalance").html(value);
        }
    });
}

function general() {
    $.ajax({
        type: "GET",
        url: SearaApp.baseURL + 'api/saldo-geral',
        dataType: "json",
        success: function (response) {
            var value = formatFloatToBrCoin(response)
            $("#generalBalance").html(value);
        }
    });
}

function hideDivs() {
    $("#divEntradas").hide();
    $("#diventries_value").hide();
    $("#entries_value").hide();
}

function showDivs() {
    $("#divEntradas").show();
    $("#diventries_value").show();
    $("#entries_value").show();
}

function searchPeriod() {
    var init = brDatetoUsa($("#dateInitial").val())
    var end = brDatetoUsa($("#dateEnd").val())
    if ( $.fn.dataTable.isDataTable( '#entry-table' ) ) {
        let colunas = [
            {data: 'entries_date_launch', name: 'entries_date_launch'},
            {data: 'entries_description', name: 'entries_description'},
            {data: 'entries_value', name: 'entries_value'},
            {data: 'entries_id_account', name: 'entries_id_account'},
            {data: 'entries_id_user', name: 'entries_id_user'},
            {data: 'action', name: 'action'}
        ];

        var table = $('#entry-table').DataTable( {
            paging: false,
            retrieve: true,
            pageLength: 100
        } );
        table.destroy();
        table = $('#entry-table').DataTable( {
            pageLength: 100,
            ajax: SearaApp.baseURL+'all-launch?dtIni='+init+'&dtEnd='+end,
            columns: colunas,
            order: [[ 0, "asc" ]],
            drawCallback: function () {
                var api = this.api();
                var sum = 0;
                $( api.table().footer() ).html(
                    sum = api.column( 2, {page:'current'} ).data().sum()
                );
              }
        } );
    }
    else {
        table = $('#entry-table').DataTable( {
            paging: false
        } );
        console.log('primeiro else');
    }
}

var dtInit = '';
var dtEnd = '';

function showReport() {
    dtInit = btoa($("#dateInitial").val()); 
    dtEnd = btoa($("#dateEnd").val()); 
    $("#btn-print-report").attr('href', SearaApp.baseURL+'lancar/relatorio/dtIni/'+dtInit+'/dtEnd/'+ dtEnd );
}

function getFiles(id) {
    $.get(SearaApp.baseURL+'/info-launch/'+id, function (data, textStatus, jqXHR) {
        $.each(data, function (index, val) { 
            //url da imagem
            var imgPublic = SearaApp.assetURL+'img/images/';
            //formato de data brasileiro
            var dtBr = dataAtualFormatada(val.createadFiles);
            if(val.hasOwnProperty('file_launches_name')) {
                $("#tbodyFilesEntriEdit").append('<tr>'+
                '<td><input type="checkbox" name="checkFilesLaunch[]" value="'+val.idFileLaunch+'"></td>'+
                '<td style="width: 20%">'+
                        '<a href="'+SearaApp.baseURL+'/img/images/'+val.file_launches_name+'" data-lightbox="roadtrip" data-title="Conta: '+val.entries_description+'"> <img src="'+imgPublic+val.file_launches_name+'" style="width: 80%"> </a>'+
                    '</td>'+
                    '<td>'+dtBr+'</td>'+
                '</tr>');
            }
           
        });
    });
}

/** Modal de alterar lançamento*/
$('#modalEditLauch').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    $("#dateLaunchEdit").val(button.data('date'));
    $("#entriesDescriptionEdit").val(button.data('his'));
    $("#entriesValueEdit").val(button.data('val'));
    $("#labelDescType").html(button.data('typ'));
    $("#idLaunchEdit").val(button.data('id'));
    $("#btnShowModalUpload").attr('data-id', button.data('id'));
    //ADICIONANDO O ID DO LANÇAMENTO AO MODAL DE UPLOAD DE ARQUIVOS
    $('.idEntry').val(button.data('id'));

    $.get(SearaApp.baseURL+'account/launch/all', function (data, _textStatus, _jqXHR) {
        var dataOptions = {
            id: button.data('idlau'),
            text: button.data('namel')
        };

        var newOption = new Option(dataOptions.text, dataOptions.id, false, false);
        $('#cod_accountEdit').append(newOption).trigger('change');
        var accontLauntAll = [];
        $.each(data, function (_indexInArray, el) { 
            accontLauntAll.push({'id': el.id, 'text': el.text});
        });

        $('#cod_accountEdit').select2({
            data: accontLauntAll
        }) 
        getFiles(button.data('id'))
    });
})

$('#modalEditLauch').on('hidden.bs.modal', function (_e) {
    //LIMPANDO O SELECT PARA PROXIMO MODAL
    $('#cod_accountEdit').empty();
    $(this).removeData();
    $("#tbodyFilesEntriEdit").empty();
})

$("#btnEditLaunch").click(function (e) { 
    e.preventDefault();
    var form = $("#formEditLaunch").serialize();

    var idLaunch = $("#idLaunchEdit").val();
    $.ajax({
        type: "POST",
        url: SearaApp.baseURL+'lancar/'+idLaunch,
        data: form,
        dataType: "json",
        success: function (_response) {
            getLaunch();
            new PNotify({
                title: 'Sucesso',
                text: 'Lançamento alterado',
                type: 'success',
                styling: 'bootstrap3'
            });
        }
    });
});

//AO CLICAR NO ADD UPLOAD O MODAL DE EDIÇÃO É OCUTADO
$("#btnShowModalUpload").click(function (e) { 
    e.preventDefault();
    $("#modalEditLauch").modal('hide');
    // $("#modalUploadLaunch").modal('show');
});

$("#btnTrashLaunch").click(function (e) { 
    e.preventDefault();
    var form = $("#formFilesLaunch").serialize();
    var idLaunch = $("#idLaunchEdit").val();
    $.ajax({
        type: "POST",
        url: SearaApp.baseURL+'api/deleteFiles',
        data: form,
        dataType: "json",
        success: function (response) {
            if(response.status == 200) {
                $("#tbodyFilesEntriEdit").empty();
                new PNotify({
                    title: 'Sucesso',
                    text: 'Arquivo excluído',
                    type: 'success',
                    styling: 'bootstrap3',
                    icon: 'fa fa-check'
                });
                getFiles(idLaunch);
            }
        }
    })
    .fail(function(jqXHR){
        notify.response(jqXHR.responseJSON);
    });
});

function formatValueToFront(action, idAccountBank, balanceInternal, smalTextInfo) {
    var id = idAccountBank;//VALOR ESCOLHIDO NO SELECT
    console.log({id})
    var valueIntenal = balanceInternal;//VALOR DO CAIXA INTERNO
    //SE A ESCOLHA FOR CAIXA INTERNO
    if(id == 0 ){
        $("#valueGetInfo").val(valueIntenal);//RECEBE O VALOR DO CAIXA INTERNO
        $("#"+smalTextInfo).html(valueIntenal);//FORMATANDO NO FRONTEND
    }else{
        //CONSULTANDO INFORMACAO DA CONTA BANCARIA
        $.get(SearaApp.baseURL + 'api/account-bank/get-info-account/' + id,
            function (data, textStatus, jqXHR) {
                var valueReal = formatFloatToBrCoin(data.balance);
                if(action == 'saida'){
                    $("#valueGetInfo").val(data.balance);//RECEBE O VALOR DA CONTA ESCOLHIDA
                }
                $("#"+smalTextInfo).html(valueReal);//FORMATANDO NO FRONTEND
            }
        );
    }
}

//SELECT DA PRIMEIRA CONTA
$("#selectAccountBankEnd").change(function (e) { 
    e.preventDefault();
    formatValueToFront(
        'saida',
        $("#selectAccountBankEnd").val(), 
        $("#balanceInternal").val(), 
        'balanceEndAccount'
    );
});

$("#selectAccountBankEntry").change(function (e) { 
    e.preventDefault();
    formatValueToFront(
        'entrada',
        $("#selectAccountBankEntry").val(), 
        $("#balanceInternal").val(), 
        'balanceEntryAccount'
    );
}); 
//AO SAIR DO CAMPO SE FAZ A VELIDAÇÃO DE VALORES
$('#realValueTranfer').on('blur', function () {
    var valueAccountBank = $("#valueGetInfo").val();
    var valueRealTransfer = $('#realValueTranfer').val();
    //CONVERTENDO O VALOR REAL PARA FLOAT
    var valor = convertBrCoinToFloat(valueRealTransfer);
    //SE O VALOR FOR MAIOR QUE O VALOR DA CONTA BANCARIA
    if(valor > parseFloat(valueAccountBank)) {
        $("#realValueTranfer").focus();
        new PNotify({
            title: 'Erro',
            text: 'Valor maior que o saldo da conta',
            type: 'error',
            styling: 'bootstrap3'
        });
        return false;
    }    
});

function transferValue() {
    if($("#realValueTranfer").val() == '' ||
    $("#selectAccountBankEnd").val() == '' ||
    $("#selectAccountBankEntry").val() == '') {
        new PNotify({
            title: 'Erro',
            text: 'O valor e as contas bancárias devem ser preenchidos',
            type: 'error',
            styling: 'bootstrap3'
        });
        return false;
    }
    var data = {
        idAccountEnd : $("#selectAccountBankEnd").val(),
        idAccountEntry : $("#selectAccountBankEntry").val(),
        value : $("#realValueTranfer").val()
    }
    SearaAjax.post('transferir', data, function( response ){
        console.log(response)
        // notify.response(response);
        // companyTable.reloadTable();
    })
    .fail(function(jqXHR){
        notify.response(jqXHR.responseJSON);
    })
    .always(function(){
        SearaLoader.hideModal();
    });
}







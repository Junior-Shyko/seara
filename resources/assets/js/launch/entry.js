$(document).ready(function () {

    //id da empresa
    var idCompany = $("#idCodeCompany").val();
    //OCULTANDO DIVE DE LANÇAMENTO EM BANCO
    $("#form-launch-register").css('display' , 'none');

    $('#entries_value').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $('#realValueTranfer').maskMoney(
        {allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    $("#lancar_conta").modal('show');
    $("#realValueTranfer").attr('disabled','disabled');
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
    getLaunch(idCompany);

    //valores do caixa banco
    bankBalance(idCompany);
    
   
    internalBalance(idCompany);
    general(idCompany);
    $("#save_entry").click(function(){
        
        
        // SearaAjax.post('lancar', form, function( response ){
        //     $("#lancar_conta").modal('hide');
        //     if(response.typeAccount == 'Despesa') {
        //         $("#modalUploadLaunch").modal('show');
        //     }
        //     $(".idEntry").val(response.id);
        //     $("#entry-table").DataTable().ajax.reload();
        //     bankBalance(idCompany);
        //     internalBalance(idCompany);
        //     general(idCompany);
        //     new PNotify({
        //         title: 'Sucesso',
        //         text: response.message,
        //         type: response.status,
        //         styling: 'bootstrap3'
        //     });
        //     if(response.typeAccount == 'Receita') {
        //         setTimeout(() => {
        //             window.location.reload();
        //         }, 2000);
        //     }
           
        // })
        // .fail(function(jqXHR){
        //     notify.response(jqXHR.responseJSON);

        // })
        // .always(function(){
        //     //console.log('hideModal');
        // });
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

    var $form_entry_internal = $(".form_entry_internal");
    $form_entry_internal.select2();
    $form_entry_internal.on("change", function (e) {
        console.log(e)
        getLaunchAccount(e.delegateTarget.value);
    });

    var $form_entry_bank = $(".form_entry_bank");
    $form_entry_bank.select2();
    $form_entry_bank.on("change", function (e) {
        console.log(e)
        getLaunchAccount(e.delegateTarget.value);
    });
});

function getLaunchAccount(codAccount) {
    $.get(SearaApp.baseURL+'/launch/account/search/'+codAccount, function(data) {
        /*optional stuff to do after success */
        console.log(data[0]);
        $(".label_desc_type").html(data[0].account_types_name);
        $(".entries_description").val(data[0].accountlaunch_history);
        // $(".account_launches_referring").html(data[0].account_launches_referring);
        showDivs();
    });
}    
var idCompany = $("#idCodeCompany").val();

function getLaunch(idCompany) {
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
        ajax: SearaApp.baseURL+'all-launch/'+idCompany,
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

function bankBalance(idCompany) {
    var valueBankBalance = '';
    $.ajax({
        type: "GET",
        url:SearaApp.baseURL + 'api/saldo-banco/' + idCompany,
        dataType: "json",
        success: function (response) {
            var value = formatFloatToBrCoin(response)
            $("#bankBalance").html(value);
            $("#balance_bank").html('R$: ' + value);
        }
    });
}

function internalBalance(idCompany) {
    $.ajax({
        type: "GET",
        url: SearaApp.baseURL + 'api/saldo-interno/'+idCompany,
        dataType: "json",
        success: function (response) {
            var value = formatFloatToBrCoin(response)
            $("#internalBalance").html(value);
            $("#balance_c_internal").html('R$: ' + value);
        }
    });
}

function general(idCompany) {
    $.ajax({
        type: "GET",
        url: SearaApp.baseURL + 'api/saldo-geral/'+idCompany,
        dataType: "json",
        success: function (response) {
            var value = formatFloatToBrCoin(response)
            $("#generalBalance").html(value);
            $("#balance_box_general").html(' R$: ' + value);
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

function searchPeriod(idCompany) {
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
            ajax: SearaApp.baseURL+'all-launch/'+idCompany+'?dtIni='+init+'&dtEnd='+end,
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

function showReport(idCompany) {
    dtInit = btoa($("#dateInitial").val()); 
    dtEnd = btoa($("#dateEnd").val()); 
    $("#btn-print-report").attr('href', SearaApp.baseURL+'lancar/relatorio/dtIni/'+dtInit+'/dtEnd/'+ dtEnd + '/company/'+idCompany );
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
            getLaunch(idCompany);
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
    $("#realValueTranfer").removeAttr('disabled');
    formatValueToFront(
        'saida',
        $("#selectAccountBankEnd").val(), 
        $("#valueInternal").val(), 
        'balanceEndAccount'
    );
});

$("#selectAccountBankEntry").change(function (e) { 
    e.preventDefault();
    
    if($("#selectAccountBankEntry").val() == $("#selectAccountBankEnd").val()){
        new PNotify({
            title: 'Ops!',
            text: 'Não poderá fazer transferencia para mesma',
            type: 'error',
            styling: 'bootstrap3'
        });
        return false;
    }
    
    formatValueToFront(
        'entrada',
        $("#selectAccountBankEntry").val(), 
        $("#valueInternal").val(), 
        'balanceEntryAccount'
    );
}); 
//AO SAIR DO CAMPO SE FAZ A VELIDAÇÃO DE VALORES
$('#realValueTranfer').on('blur', function () {
    // var valueAccountBank = $("#valueGetInfo").val();
    // var valueRealTransfer = $('#realValueTranfer').val();
    // //CONVERTENDO O VALOR REAL PARA FLOAT
    // var valor = convertBrCoinToFloat(valueRealTransfer);
    // //SE O VALOR FOR MAIOR QUE O VALOR DA CONTA BANCARIA
    // if(valor > parseFloat(valueAccountBank)) {
    //     $("#realValueTranfer").focus();
    //     new PNotify({
    //         title: 'Erro',
    //         text: 'Valor maior que o saldo da conta',
    //         type: 'error',
    //         styling: 'bootstrap3'
    //     });
    //     return false;
    // }    
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
    var bank_to_bank = false;
    //PARA MOVIMENTAÇÃO DE BANCO PARA BANCO
    if($("#selectAccountBankEnd").val() > 0 && $("#selectAccountBankEntry").val() > 0)
    {
        bank_to_bank = true;
    }
    var data = {
        idAccountEnd : $("#selectAccountBankEnd").val(),
        idAccountEntry : $("#selectAccountBankEntry").val(),
        value : $("#realValueTranfer").val(),
        valueInternal: $("#valueInternal").val(),
        transaction_id : $("#transaction_id_transfer").val(),
        bank_to_bank: bank_to_bank
    }

    // return;
    SearaAjax.post('transferir', data, function( response ){
        console.log(response)
        if(response.type == 'success')
        {
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: 'success',
                styling: 'bootstrap3'
            });
            setTimeout(() => {
                window.location.reload(); 
            }, 2000);
        }
    })
    .always(function(response){
        console.log({response})
        if(response.type == 'error')
        {
            new PNotify({
                title: 'Ops!',
                text: response.message,
                type: 'error',
                styling: 'bootstrap3'
            });
        }
       
        SearaLoader.hideModal();
       
    });''
}

function saveDataForm(name_form) {
    var form = $('#'+name_form).serialize();
    console.log(form)
    var seriArray = $('#'+name_form).serializeArray();

//VAR INICIANDO COMO FALSO PARA LANCAMENTO CAIXA INTERNO
    var verifyBank = false;
    var idBank = 0;
    var valueLanchBank = 0;
console.log({seriArray})
    //FAZENDO UMA VARREDURA NOS CAMPOS DO FORMULARIO
jQuery.each( seriArray, function( i, field ) {
    //SE ACHAR O INDICE ENTRIES_BANK ENTAO ALTERA O VALOR DA VARIAVEL
    if(field.name == 'entries_bank') {
        verifyBank = true;
        idBank = seriArray[i].value;
        valueLanchBank = seriArray[3].value;
    }

  } );
    if(verifyBank) {
       alterValueBank(idBank, valueLanchBank);
    }

    return;
    SearaAjax.post('lancar', form, function( response ){
        $("#lancar_conta").modal('hide');
        if(response.typeAccount == 'Despesa') {
            $("#modalUploadLaunch").modal('show');
        }
        $(".idEntry").val(response.id);
        $("#entry-table").DataTable().ajax.reload();
        bankBalance(idCompany);
        internalBalance(idCompany);
        general(idCompany);
        new PNotify({
            title: 'Sucesso',
            text: response.message,
            type: response.status,
            styling: 'bootstrap3'
        });
        if(response.typeAccount == 'Receita') {
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }
        
    })
    .fail(function(jqXHR){
        notify.response(jqXHR.responseJSON);

    })
    .always(function(){
        //console.log('hideModal');
    });
}
function alterValueBank(idBank, valueLanchBank){
    var agencyAccountBa   = $("#input_form_agency_bank").val();
    var idNumberAccount = $("#input_form_number_account").val();
    var typeAccountbank = $("#input_form_type_account").val();
    // console.log(idBank, valueLanchBank, idAccountBank, idNumberAccount, typeAccountbank)
    var dataPost = {
        idBank: idBank,        
        agencyAccountBa: agencyAccountBa,
        idNumberAccount: 333333,
        typeAccountbank: typeAccountbank,
        valueLanchBank: valueLanchBank
    }
    SearaAjax.post('api/alter-balance-bank', dataPost, function( response ){
        console.log(response)
        if(response == 'error') {
            console.log(response)
            new PNotify({
                title: 'Error',
                text: 'Ocorreu um erro inexperado',
                type: 'error',
                styling: 'bootstrap3'
            });
        }
    })
    .fail(function(jqXHR){
        // notify.response(jqXHR.responseJSON);
        console.log(jqXHR)
    })
    
}
//REMOVENDO OS VALORES DOS INPUTS DO FORMULÁRIO
function clearField(name_form) {
    $('#' + name_form)[0].reset();
    clearSelect2Form()
}
//AÇÃO QUANDO CLICAR NAS TABS
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    // newly activated tab
    console.log(e)
    // previous active tab
    console.log(e.target.dataset.form)
   switch (e.target.dataset.form) {
       case 'form_entry_internal':
            clearSelect2Form();
            clearField('form_entry_internal');
            $("#center-info-data-bank").remove();
            break;
   
       default:
           break;
   }
 })

function clearSelect2Form()
{
    $('.form_entry_internal').val(null).trigger('change');
    $(".label_desc_type_internal").html('. . .')
}
$(function () {
    
    $("#select-form-option-bank").change(function (e) { 
        e.preventDefault();
        console.log(e)
        $("#center-info-data-bank").empty();
        console.log($("#select-form-option-bank").find(':selected').data('num'))
        var numberAccount = $("#select-form-option-bank").find(':selected').data('num');
        var typeAccount = $("#select-form-option-bank").find(':selected').data('type');
        var agencyBank = $("#select-form-option-bank").find(':selected').data('age');

        if(e.target.value !== '--') {            
            $("#form-launch-register").css('display' , 'block');
            $("#form-launch-register").addClass('animated bounceInUp');
            $("#jumbotron-lauch").append('<div class="col-md-12 form-inline center-info-data-bank" id="center-info-data-bank"></div>');
            $("#center-info-data-bank").append('<div class="form-group">'+
                    '<label for="">Ag. : </label>'+
                    '<input type="text" name="ag_bank" value="'+agencyBank+'" class="form-control  h-20 ml-3" id="input_form_agency_bank" disabled placeholder="Jane Doe">'+
                '</div>'+
                '<div class="form-group">'+
                    '<label for="">Conta : </label>'+
                    '<input type="text" name="num_account" value="'+numberAccount+'" class="form-control h-20 ml-3" id="input_form_number_account" disabled placeholder="jane.doe@example.com">'+
                '</div>'+
                '<div class="form-group">'+
                    '<label for="">Tipo : </label>'+
                    '<input type="text" name="type_account" value="'+typeAccount+'" class="form-control h-20 ml-3" id="input_form_type_account" disabled placeholder="jane.doe@example.com">'+
                '</div>')
        }else{
            $("#form-launch-register").css('display' , 'none');
            $("#center-info-data-bank").remove();
        }
    });
});





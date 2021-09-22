
$(document).ready(function () {
    //$("#modalUploadLaunch").modal('show');
    //$("#lancar_conta").modal('show');
    $('#entries_value').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
   
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

    let colunas = [
        {data: 'entries_date_launch', name: 'entries_date_launch'},
        {data: 'entries_description', name: 'entries_description'},
        {data: 'entries_value', name: 'entries_value'},
        {data: 'entries_id_account', name: 'entries_id_account'},
        {data: 'entries_id_user', name: 'entries_id_user'},
        {data: 'action', name: 'action', searchable: false, className: 'nowrap'},
    ];
    $('#entry-table').DataTable({
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
            this.on("success", function (file, response) {
                console.log(response);
                notify.response(response);
            });
            this.on("error", function (file, error, xhr) {
                console.log({file})
                console.log({error})
                console.log({hr})
            });
        }
    }); 
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
            console.log(jqXHR);
        })
        .always(function(){
            console.log('hideModal');
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

    $('#modalUploadLaunch').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id') 
      var modal = $(this)
      modal.find('.idEntry').val(id);
    })
    
    $('#modalInfoLaunch').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id')
        $.get('info-launch/'+id,
        function (data, textStatus, jqXHR) { 
            $("#linkEdit").attr('href', SearaApp.baseURL+ 'lancar/' +data[0].entries_id+'/edit');
            var dt = dataAtualFormatada(data[0].createEntry);
            $(".day").html('Dia: '+dt);
            $(".his").html('Histórico: '+data[0].entries_description);
            $(".value").html('Valor: '+data[0].entries_value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
            $(".account").html('Conta: '+data[0].accountlaunch_name);
            $(".type").html('Dia: '+data[0].account_types_name);
            $(".per").html('Por: '+data[0].nameUser);
                $.each(data, function (indexInArray, valueOfElement) { 
                    if(typeof valueOfElement.file_launches_name !== 'undefined'){
                        console.log(typeof valueOfElement.file_launches_name);
                        $("#filesEntri").append('<div class="col-md-6 col-xs-12">'+
                        '<a href="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" class="thumbnail" data-lightbox="roadtrip" data-title="Conta: '+valueOfElement.entries_description+'"> <img src="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" '+'> </a>')
                    }
                });
            }
        );
    })
    $('#modalInfoLaunch').on('hidden.bs.modal', function (e) {
        $("#filesEntri div").remove();
    })

    $("#cod_account").change(function(event) {
    hideDivs();
    	/* Act on the event */
        var codAccount = $("#cod_account").val();
	    $.get(SearaApp.baseURL+'/launch/account/search/'+codAccount, function(data) {
	    	/*optional stuff to do after success */
            console.log(data[0]);
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

// $("#dateInitial").blur(function (e) { 
//     e.preventDefault(); 
    
//     console.log({dtInit})
//     $("#btn-print-report").attr('href', SearaApp.baseURL+'lancar/relatorio/dtIni/'+dtInit+'/dtEnd/'+ dtEnd );
// });

// $("#dateEnd").blur(function (e) { 
//     e.preventDefault(); 
    
//     console.log({dtEnd})
//     $("#btn-print-report").attr('href', SearaApp.baseURL+'lancar/relatorio/dtIni/'+dtInit+'/dtEnd/'+ dtEnd );
// });
 function showReport() {
    dtInit = btoa($("#dateInitial").val()); 
    dtEnd = btoa($("#dateEnd").val()); 
    $("#btn-print-report").attr('href', SearaApp.baseURL+'lancar/relatorio/dtIni/'+dtInit+'/dtEnd/'+ dtEnd );
 }







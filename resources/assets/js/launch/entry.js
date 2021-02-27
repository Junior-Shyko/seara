
$(document).ready(function () {
    //$("#modalUploadLaunch").modal('show');
    //$("#lancar_conta").modal('show');

    $("#divRectroativeLaunch").hide();
    $("#dateRetroactive").hide();
    let colunas = [
        {data: 'entries_day', name: 'entries_day'},
        {data: 'entries_description', name: 'entries_description'},
        {data: 'entries_value', name: 'entries_value'},
        {data: 'entries_id_account', name: 'entries_id_account'},
        {data: 'entries_id_user', name: 'entries_id_user'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'nowrap'},
    ];
    $('#entry-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: SearaApp.baseURL+'all-launch',
        columns: colunas
    });
    
    Dropzone.autoDiscover = false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var idEntry = $("#idEntry").val();
    $("#form-upload-entry").dropzone({ 
        url: "/caixa/upload",
        params: idEntry,
        autoProcessQueue: true,
        dictDefaultMessage: "Arraste seus arquivos para essa área ou click para localizar",
        maxFiles: 4,
        dictMaxFilesExceeded: 'Você nao pode enviar mais arquivo',
        maxFilesize: 1,
        dictFileTooBig: 'O Arquivo excedeu o limite máximo permitido',
        clickable: true,
        uploadMultiple: true,
        addRemoveLinks: true,
        dictRemoveFile: 'Remover',
        acceptedFiles: 'image/png, image/jpeg, application/pdf',
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
    $("#save_entry").click(function(){
        var form = $('form#form_entry').serialize();

        SearaAjax.post('lancar', form, function( response ){
            console.log(response)
            $("#lancar_conta").modal('hide');
            $("#modalUploadLaunch").modal('show');
            $(".idEntry").val(response.id);
            $("#entry-table").DataTable().ajax.reload();
            // notify.response(response);
            // companyTable.reloadTable();
            new PNotify({
                title: 'Sucesso',
                text: response.message,
                type: response.status,
                styling: 'bootstrap3'
            });
            // $("#account-launch-table").DataTable().ajax.reload();
            // $("#form-account-launch").each (function(){
            //   this.reset();
            // });
        })
        .fail(function(jqXHR){
            notify.response(jqXHR.responseJSON);
            console.log(jqXHR);
        })
        .always(function(){
            //SearaLoader.hideModal();
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
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('New message to ' + recipient)
      modal.find('.modal-body input').val(recipient)
    })
    
    $('#modalInfoLaunch').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id')
        $.get('info-launch/'+id,
        function (data, textStatus, jqXHR) { 
            var dt = dataAtualFormatada(data[0].createEntry);
            $(".day").html('Dia: '+data[0].entries_day);
            $(".his").html('Histórico: '+data[0].entries_description);
            $(".value").html('Valor: '+data[0].entries_value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
            $(".account").html('Conta: '+data[0].accountlaunch_name);
            $(".type").html('Dia: '+data[0].account_types_name);
            $(".created").html('Criado em: '+dt);
            $(".per").html('Por: '+data[0].nameUser);
                $.each(data, function (indexInArray, valueOfElement) { 
                    console.log(valueOfElement);
                    var dt = dataAtualFormatada(valueOfElement.createEntry);
                    $("#filesEntri").append('<div class="col-md-12 col-xs-12">'+
                    '<a href="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" class="thumbnail" data-lightbox="roadtrip" data-title="Conta: '+valueOfElement.entries_description+'"> <img src="'+SearaApp.baseURL+'/img/images/'+valueOfElement.file_launches_name+'" '+'> </a>')
                });
            }
        );
    })
    $('#modalInfoLaunch').on('hidden.bs.modal', function (e) {
        console.log('excluo tudo');
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
    $.datetimepicker.setLocale('pt-BR');
    $('#dateRetroactive').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });
});

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
$("#castRetroactive").click(function (e) { 
    e.preventDefault();
    $("#save_entry").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar retroativo');
    $("#save_entry").removeClass('alert-primary');
    $("#save_entry").addClass('btn-dark');
    $("#infoMonthLaunch").removeClass('alert-info');
    $("#infoMonthLaunch").addClass('btn-dark');
    $("#divRectroativeLaunch").show();
    $("#divActualLaunch").hide();
    $("#entries_day").hide();
    $("#dateRetroactive").show();
    $("#typeLaunch").val('retroactive');
    $("#dateRetroactive").attr('name','entries_day'); 
});
$("#launchMonth").click(function (e) { 
    e.preventDefault();
    $("#save_entry").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Lançamento');
    $("#infoMonthLaunch").addClass('alert-info');
    $("#infoMonthLaunch").removeClass('btn-dark');
    $("#save_entry").removeClass('btn-dark');
    $("#save_entry").addClass('alert-primary');
    $("#divRectroativeLaunch").hide();
    $("#divActualLaunch").show();
    $("#typeLaunch").val('actual');
    $("#entries_day").show();
    $("#dateRetroactive").removeAttr('name');
    console.log($("#dateRetroactive"));
});

function showInfo(id) {
  
    $("#modalInfoLaunch").modal('show');
}
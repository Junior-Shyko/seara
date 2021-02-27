$(document).ready(function () {
    //$("#modalUploadLaunch").modal('show');
    //$("#lancar_conta").modal('show');
    $("#divRectroativeLaunch").hide();
    $("#dateRetroactive").hide();
    hideDivs();
    $('#entries_value').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
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
    $("#form-upload-entry").dropzone({ 
        url: "/caixa/upload",
        autoProcessQueue: true,
        dictDefaultMessage: "Arraste seus arquivos para essa área ou click para localizar",
        maxFiles: 2,
        clickable: true,
        uploadMultiple: true,
        paramName: 'file',
        addRemoveLinks: true
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
            // new PNotify({
            //     title: 'Sucesso',
            //     text: response.message,
            //     type: response.status,
            //     styling: 'bootstrap3'
            // });
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

$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});
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
$(function() {
    
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Visualização do arquivo</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Procurar");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
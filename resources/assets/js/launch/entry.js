$(document).ready(function () {
    //$("#modal-entry").modal('show');
    $("#lancar_conta").modal('show');
    hideDivs();
    $('#entries_value').maskMoney(
        {prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}
    );
    
    $("#form_entry").dropzone({ 
        url: "/caixa/upload",
        autoProcessQueue: false,
        dictDefaultMessage: "Arraste seus arquivos para essa área ou click para localizar",
        maxFilesize: 6,
        clickable: true,
        uploadMultiple: true
    }); 
    $("#save_entry").click(function(){
        var form = $('form#form_entry').serialize();

        SearaAjax.post('lancar', form, function( response ){
            console.log(response)
            $("#lancar_conta").modal('hide');
            $("#modalUploadLaunch").modal('show');

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
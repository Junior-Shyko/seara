<style>
.image-preview-input {
    position: relative;
	overflow: hidden;
	margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
.image-preview-input-title {
    margin-left:2px;
}
</style>
<!-- Modal upload launch-->
<div class="modal fade" id="modalUploadLaunch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="">Upload de arquivos</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">  
                <span aria-hidden="true">&times;</span>
              </button>
              <p>Aqui você poderá anexar seus arquivos de recibo, nota fiscal e etc. Além de poder enviar até 04 arquivos de um só vez.</p>
          </div>
          <div class="row">
            <form class="dropzone" id="form-upload-entry"  enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" name="idEntry" class="idEntry">
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-close"></i> Fechar
              </button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          
          {{-- <input type="text" name="idEntry" class="idEntry">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
<!-- Modal upload launch-->
<div class="modal fade" id="modalUploadLaunch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Upload de arquivos</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <p>Aqui você poderá anexar seus arquivos de recibo, nota fiscal e etc.</p>
          </div>
          <div class="row">
            <form class="dropzone" id="form-upload-entry"  enctype="multipart/form-data">
              {{ csrf_field() }}
            
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <input type="text" name="idEntry" class="idEntry">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
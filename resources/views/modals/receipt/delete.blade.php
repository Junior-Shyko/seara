<!-- /.modal delete user-->
<div class="modal fade"  id="modal_delete_receipt" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmação de exclusão</h4>
      </div>
      <div class="modal-body">
        <h3 id="modal_delete_receipt_text"></h3>
      </div>
      <div class="modal-footer">
        <form id="form-delete-receipt" action="" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="btn btn-default pull-left" data-dismiss="modal" type="button">Não</button>
          <button class="btn btn-danger" type="submit">Sim</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal delete user-->

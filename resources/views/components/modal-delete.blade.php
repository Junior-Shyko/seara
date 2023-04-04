<!-- /.modal delete user-->
<div class="modal fade"  id="{{ $id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $title }}</h4>
      </div>
      <div class="modal-body">
        <h5>{{ $slot }}</h5>
        <p> 
          {{$inputs}}
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default pull-left" data-dismiss="modal" type="button">Não</button>
        <button id="{{$idBtnModal}}"  class="btn btn-danger">Sim</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal delete user-->

<!-- /.modal delete user-->
<div class="modal fade "  id="{{$modal_id_delete}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{$description_modal}}</h4>
      </div>
      {{ Form::open(array('url' => $url_route, 'method' => 'delete')) }}
      <div class="modal-body">

        <h3>{{$text_delete}}</h3>
        {{Form::hidden($name_camp , $value_camp)}}

      </div>
      <div class="modal-footer">
        {{ Form::button('Não', array('class' => 'btn btn-default pull-left' , 'data-dismiss' => 'modal')) }}
        {{ Form::submit('Sim', array('class' => 'btn btn-danger')) }}
      </div>
      {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal delete user-->

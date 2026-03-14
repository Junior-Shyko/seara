<!-- /.modal delete user-->
<div class="modal fade "  id="alter_entry_{{$entries->entries_id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alert-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Alterar Lançamento</h4>
      </div>
      {{Form::open(['url' => 'lancar/'.$entries->entries_id , 'method' => 'PUT'])}}
      <div class="modal-body">
        <div class="row">
          @if (!empty($entries->entries_decimate))
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Alterar Dízimo 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" required="required" name="entries_decimate" id="alter_entries_decimate" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
          @endif
           @if (!empty($entries->entries_offer))
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Alterar Oferta
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" required="required" name="entries_offer" id="alter_entries_offer" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
          @endif
           @if (!empty($entries->entries_other))
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Alterar outras entradas
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" required="required" name="entries_other" id="alter_entries_other" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
          @endif
          @if (!empty($entries->entries_end))
          
        
            <div class="form-group">
              <div class="col-md-3">
                {{Form::label('day_launch' , 'Dia do Lançamento')}}
                {{Form::text('entries_day' , $entries->entries_day  , ['id' => 'entries_day' , 'class' =>'form-control'] )}}
              </div>
              <div class="col-md-9">
                {{Form::label('entries_end' , 'Alterar valor de saída')}}
                {{Form::text('entries_end' , $entries->entries_end, ['id' => 'alter_entries_end' , 'class' =>'form-control'] )}}
              </div>
              <div class="col-md-12">
                {{Form::label('description' , 'Descrição')}}
                {{Form::text('entries_description' , $entries->entries_description, ['id' => 'alter_entries_description' , 'class' =>'form-control'] )}}
              </div>
            </div>
          @endif
        </div>
        
       

      </div>
      @if ($entries->fileLaunches->isNotEmpty())
      <div class="modal-body" style="border-top: 1px solid #e5e5e5;">
        <h5><strong>Arquivos anexados</strong></h5>
        <table class="table table-striped table-condensed">
          <thead>
            <tr>
              <th>Arquivo</th>
              <th>Enviado em</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries->fileLaunches as $file)
            <tr>
              <td>
                <a href="{{ url('storage/images/' . $file->file_launches_name) }}" target="_blank">
                  <img src="{{ url('storage/images/' . $file->file_launches_name) }}" alt="{{ $file->file_launches_name }}" style="max-height:60px; max-width:80px; object-fit:cover;">
                </a>
              </td>
              <td>{{ $file->created_at }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        <button type="submit" class="btn btn-primary"  id="alter_save_entry">Alterar Lançamento <i class="fa fa-check-square" aria-hidden="true"></i></button>
      </div>
      {{Form::close()}}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal delete user-->

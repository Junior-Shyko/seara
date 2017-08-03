<!-- /.modal delete user-->
<div class="modal fade "  id="modal_close_box" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Fechar Caixa Atual</h4>
      </div>
      {{ Form::open(array('url' => 'fechar-caixa', 'method' => 'post')) }}
      <div class="modal-body">

        <h3>Deseja realmente fechar esse caixa?</h3>
        <p style="color: #fff;" class="alert-info text-center"><label>Informações</label></p>
       <table class="table table-striped">
            <thead>
              <tr>
                <th>Data Abertura</th>
                <th>Status</th>
                <th>Aberto por</th>
                <th>Valor Incial</th>
                <th>Cadastrado</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>{{(count($box) == 0 ? '' : date('d/m/Y' , strtotime($box[0]->boxies_date_open)) )}}</th>
                <td>{{(count($box) == 0 ? '' : $box[0]->boxies_status)}}</td>
                <td>
                <?php 
                  if(count($box) > 0)
                  {
                    App\FunctionGeneral::getName($box[0]->boxies_id_users);  
                  }
                ?> 
                </td>
                <td>{{(count($box) == 0 ? '' :  number_format($box[0]->boxies_balance_initial, 2 , ',' , '.'))}}</td>
                 <td>{{(count($box) == 0 ? '' : date('d/m/Y' , strtotime($box[0]->created_at))) }}</td>
              </tr>
             
            </tbody>
          </table>
      <input type="text" name="boxies_id" value="{{(count($box) == 0 ? '' : $box[0]->boxies_id) }}">
      <input type="text" name="boxies_balance_end" value="{{$previus_balance}}">
      </div>
      <div class="modal-footer">
        {{ Form::button('Não', array('class' => 'btn btn-default pull-left' , 'data-dismiss' => 'modal')) }}
        {{ Form::submit('Sim', array('class' => 'btn btn-danger')) }}
      </div>
      {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal delete user-->

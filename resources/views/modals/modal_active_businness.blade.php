<div class="modal fade" id="aprovar_{{$companies->company_id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Aprovar Empresa</h4>
      </div>
      {{Form::open(['url' => 'companies/alterar-status'])}}
      <div class="modal-body">
       <div class="row">
       	<div class="col-md-12">
       		<div class="col-md-2"></div>
       		<div class="col-md-8">
       			<ul class="list-group">
			  <li class="list-group-item">Endereço: {{$companies->company_street}}</li>
			  <li class="list-group-item">Número: {{$companies->company_number}}</li>
			  <li class="list-group-item">Bairro: {{$companies->company_district}}</li>
			  <li class="list-group-item">Celular: {{$companies->company_mobile}}</li>
			  <li class="list-group-item">Fixo: {{$companies->company_phone}}</li>
			  <li class="list-group-item">Cadastro: {{date('d/m/Y' , strtotime($companies->created_at))}}</li>
			</ul>
       		</div>
       		<div class="col-md-2">
       			<input type="hidden" name="company_id" value="{{$companies->company_id}}">
       		</div>
       	</div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        <button type="submit" class="btn btn-primary">Ativar <i class="fa fa-check-square" aria-hidden="true"></i>
		</button>
      </div>
      {{Form::close()}}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
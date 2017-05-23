@extends('layouts.blank')

@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
{{Html::style('css/home.min.css')}}
<style type="text/css">
	.ui-button ui-corner-all ui-widget{
		float: left;
	}
</style>
@endpush


@section('main_container')

<div class="col-md-12">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		@include('msg.message')
	</div>
	<div class="col-md-4"></div>
</div>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-user"></i></div>
				<div class="count">179</div>
				<h3>Usuários</h3>
				<p>Total de usuário em geral.</p>
			</div>
		</div>
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-building"></i></div>
				<div class="count">179</div>
				<h3>Empresas</h3>
				<p>Total geral de todas as empresas.</p>
			</div>
		</div>
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
				<div class="count">179</div>
				<h3>New Sign ups</h3>
				<p>Lorem ipsum psdea itgum rixt.</p>
			</div>
		</div>
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-check-square-o"></i></div>
				<div class="count">179</div>
				<h3>New Sign ups</h3>
				<p>Lorem ipsum psdea itgum rixt.</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Empresas <small>Aprovar cadastro de igrejas</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a>
								</li>
								<li><a href="#">Settings 2</a>
								</li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">

					<div class="table-responsive">
						<table class="table table-bordered">
						    <thead>
						        <tr>
						            <th>Razão Social</th>
						            <th>Fantasia</th>
						            <th>Responsável</th>
						            <th>CNPJ</th>
						            <th>Data Cadastro</th>
						            <th>Aprovar</th>
						        </tr>
						    </thead>
						    <tbody>
						        @foreach($company as $companies)
						        <tr>
									<td>{{$companies->company_name}}</td>
									<td>{{$companies->company_fantasy}}</td>
									<td>{{$companies->company_responsible}}</td>
									<td>{{$companies->company_cnpj}}</td>
									<td>{{$companies->created_at}}</td>
									<td>
										<a href="#" data-toggle="modal" class="btn btn-info" data-target="#aprovar_{{$companies->company_id}}">
											<i class="fa fa-check-square-o" aria-hidden="true"></i>
										</a>

									</td>
									<div class="modal fade" id="aprovar_{{$companies->company_id}}" tabindex="-1" role="dialog">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title">Aprovar empresa</h4>
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
								</tr>
						        @endforeach
						        
						        
						    </tbody>
						</table>

					</div>


				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

@push('scripts')


    <script>
      var base_url = "{{ url('') }}"
    </script>
    <script src="{{ asset("js/home.min.js") }}"></script>
   <script type="text/javascript">
	$(function() {

		$("#dialog-confirm").hide();	

	

		

		
	});
</script>

@endpush
@endsection

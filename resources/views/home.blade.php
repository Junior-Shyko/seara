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
										<input type="checkbox" name="aprovar" id="{{$companies->company_id}}">
									</td>
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
<div id="dialog-confirm" title="Confirmação">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Deseja realmente aprovar essa igreja:</p>
</div>
@push('scripts')
    <script>
      var base_url = "{{ url('') }}"
    </script>
    <script src="{{ asset("js/home.js") }}"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$( "input[type=checkbox]" ).on( "click",function(){
    			var conf = $( "input:checked" ).val();
    			var id = $(this).closest('td').attr('id');
    			if(conf == 'on')
    			{
    				$( "#dialog-confirm" ).dialog({
				      resizable: false,
				      height: "auto",
				      width: 400,
				      modal: true,
				      buttons: {
				        Ok: function() {
				          alert('envia para o banco o '+id);
				          $( this ).dialog( "close" );
				        },
				        Cancel: function() {
				          $( this ).dialog( "close" );
				        }
				      }
				    });
    			}else if(conf == 'undefined')
    			{
    				alert('empresa reprovada');
    			}
    		});
    	});
    </script>
@endpush
@endsection

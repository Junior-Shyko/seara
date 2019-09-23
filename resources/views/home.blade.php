@extends('layouts.blank')

@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
{{-- {{Html::style('css/home.min.css')}} --}}
<style type="text/css">
	.ui-button ui-corner-all ui-widget{
		float: left;
	}

	.tile-stats .count {
		font-size: 25px;
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
				<div class="count">{{ $tot_users }}</div>
				<h3>Usuários</h3>
				<p>Total de usuários cadastrados.</p>
			</div>
		</div>
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-building"></i></div>
				<div class="count">{{ $tot_company }}</div>
				<h3>Empresas</h3>
				<p>Total de empresas ativas.</p>
			</div>
		</div>
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
				<div class="count">{{$tot_recibos}}</div>
				<h3>Recibos</h3>
				<p>Total de recibos do mês.</p>
			</div>
		</div>
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-check-square-o"></i></div>
				<div class="count">{{$valor_recibos}}</div>
				<h3>Recibos</h3>
				<p>Valor total dos recibos emitidos no mês.</p>
			</div>
		</div>
	</div>

{{--	<div class="row">--}}
{{--		<div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--			<div class="x_panel">--}}
{{--				<div class="x_title">--}}

{{--					<button class="btn btn-primary pull-right" onclick="companyTable.reloadTable()" data-toggle="tooltip" data-placement="bottom" data-original-title="Atualizar">--}}
{{--						<i class="fa fa-refresh" aria-hidden="true"></i>--}}
{{--					</button>--}}

{{--					<div class="clearfix"></div>--}}
{{--				</div>--}}

{{--				<div class="x_content">--}}

{{--					<div class="table-responsive">--}}
{{--						<table class="table table-hover" id="company-table">--}}
{{--							<thead>--}}
{{--								<tr>--}}
{{--									<th>Razão Social</th>--}}
{{--									<th>Fantasia</th>--}}
{{--									<th>Responsável</th>--}}
{{--									<th>CNPJ</th>--}}
{{--									<th>Data Cadastro</th>--}}
{{--									<th>Aprovar</th>--}}
{{--								</tr>--}}
{{--							</thead>--}}

{{--							<tbody>--}}
{{--							</tbody>--}}
{{--						</table>						--}}
{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
</div>
</div>
<!-- /page content -->

@push('scripts')


<script>
	var base_url = "{{ url('') }}"
</script>
<script src="{{ asset('js/home.min.js') }}"></script>
<script type="text/javascript">
	$(function() {

		$("#dialog-confirm").hide();	



		

		
	});
</script>

@endpush
@endsection

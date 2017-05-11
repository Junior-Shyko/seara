@extends('layouts.blank')

@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
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

					<p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p>

					<div class="table-responsive">
						<table class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
									<th>
										<div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
									</th>
									<th class="column-title" style="display: none;">Invoice </th>
									<th class="column-title" style="display: none;">Invoice Date </th>
									<th class="column-title" style="display: none;">Order </th>
									<th class="column-title" style="display: none;">Bill to Name </th>
									<th class="column-title" style="display: none;">Status </th>
									<th class="column-title" style="display: none;">Amount </th>
									<th class="column-title no-link last" style="display: none;"><span class="nobr">Action</span>
									</th>
									<th class="bulk-actions" colspan="7" style="display: table-cell;">
										<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt">1 Records Selected</span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								</tr>
							</thead>

							<tbody>
								<tr class="even pointer selected">
									<td class="a-center ">
										<div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="flat" name="table_records" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
									</td>
									<td class=" ">121000040</td>
									<td class=" ">May 23, 2014 11:47:56 PM </td>
									<td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
									<td class=" ">John Blank L</td>
									<td class=" ">Paid</td>
									<td class="a-right a-right ">$7.45</td>
									<td class=" last"><a href="#">View</a>
									</td>
								</tr>

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
    <script src="{{ asset("js/home.js") }}"></script>
    @endpush
@endsection

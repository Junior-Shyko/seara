@extends('layouts.blank')

@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
{{-- {{Html::style('css/dropzone.css')}} --}}
{{Html::style('plugins/bootstrap-fileinput/css/fileinput.min.css')}}
<style>
.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 220px;
}
</style>
@endpush

@section('main_container')

<!-- page content -->
<div class="right_col" role="main">
	<div class="row"> 
		@include('msg.message')
		<div class="x_panel">
			<div class="x_title">
				<h2>Dados da empresa <small>Editar dados</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					{{-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> --}}
					<li><a href="#upload_logo" data-toggle="modal"> <button class="btn btn-success"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Logo igreja </button> </a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Editar Presidente</a>
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
				<br>
				
				{{Form::model($company, ['route' => ['companies.update' , $company->company_id] , 'class' => 'form-horizontal form-label-left input_mask' , 'method' => 'PUT']) }}

					<div class="col-md-5 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('razao_social','Razão Social')}}
						{{Form::text('company_name' , null, ['class' => 'form-control has-feedback-left'])}}						
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('fantasia','Nome Fantasia')}}
						{{Form::text('company_fantasy' , null, ['class' => 'form-control has-feedback-left'])}}						
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('cnpj','C.N.P.J')}}
						{{Form::text('company_cnpj' , null, ['class' => 'form-control has-feedback-left' , 'id' => 'cnpj_business'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
					{{Form::label('Fone_fixo','Fone Fixo')}}
						{{Form::text('company_phone' , null, ['class' => 'form-control has-feedback-left' , 'id' => 'fone_fixo_business'])}}						
						<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
					{{Form::label('fone','Fone Celular')}}
						{{Form::text('company_mobile' , null, ['class' => 'form-control has-feedback-left' , 'id' => 'company_phone_business'])}}
						<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('endereco','Endereço')}}
						{{Form::text('company_addr_street' , null, ['class' => 'form-control has-feedback-left'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('numero','Número')}}
						{{Form::text('company_addr_number' , null, ['class' => 'form-control has-feedback-left'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('complemento','Complemento')}}
						{{Form::text('company_addr_complement' , null, ['class' => 'form-control has-feedback-left'])}}
						
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('bairro','Bairro')}}
						{{Form::text('company_addr_district' , null, ['class' => 'form-control has-feedback-left'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('cidade','Cidade')}}
						{{Form::text('company_addr_city' , null, ['class' => 'form-control has-feedback-left'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('estado','Estado')}}
						{{Form::text('company_addr_state' , null, ['class' => 'form-control has-feedback-left'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
						{{Form::label('cep','Cep')}}
						{{Form::text('company_addr_cep' , null, ['class' => 'form-control has-feedback-left'])}}
						<span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-12">
						<br>
						<div class="ln_solid"></div>
					</div>
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
														
							<button type="submit" class="btn btn-primary pull-right">Alterar</button>
						</div>
					</div>

				{{Form::close()}}
<div class="clearfix"></div>

				<div class="modal fade" id="upload_logo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Adicionar ou Alterar Logo Marca</h4>
      </div>
      <div class="modal-body">
	  
                <input id="input-700" name="kartik-input-700[]" type="file" multiple class="file">
		</div>
	 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        <button type="button" class="btn btn-primary">Upload</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

			</div>
		</div>
	</div>
</div>


@push('scripts')
<script>
	var base_url = "{{ url('') }}"
</script>
<script src="{{ asset("js/mask.min.js") }}"></script>
<script src="{{ asset("js/mask_camp.min.js") }}"></script>


<script src="{{ asset("js/company.min.js") }}"></script>
{{Html::script('plugins/bootstrap-fileinput/js/fileinput.min.js')}}
<script>
   
$("#input-700").fileinput({
                    language: "pt-BR",
                    uploadUrl: "{{url('companies/alterar-logo')}}", // server upload action
                    uploadAsync: true,
                    maxFileCount: 1,
                    showAjaxErrorDetails: false,//não mostrou mais o retorno do controller no pagina html
                    MsgInvalidFileType:'Tipo inválido para o arquivo "{name}". Somente os arquivos "{types}" são suportados.',
                    MsgInvalidFileExtension: 'Extensão inválida para o arquivo "{name}". Somente os arquivos "{extensions}" são suportados.',
                    MsgProgress: 'Lendo arquivo {index} de {files} - {name} - {porcento}% completo.',
                    DropZoneEnabled: true,
                   
                });
               $('#input-700').on('fileuploaded', function(event, data, previewId, index) {
                    var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;
                    alert('chamo a funcao de imagem do avatar');
                   getAvatar();
                });
</script>
@endpush
@endsection
<!-- /page content -->



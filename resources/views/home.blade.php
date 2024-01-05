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
    .class_name {
    color: black;
    font-size: 18px;
    margin-left: 15px;
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
    <div class="row">
        <div class="col-md-3 ">
            <div class="card x_panel fixed_height_200">
                <div class="card-body  text-center">
                    <h3 class="card-title">Conta bancária <i class="fa fa-bank"></i> </h3>
                    <p class="card-text">Ambiente voltado para cadastro e alteração de todas as suas contas banárias</p>
                    <div class="pricing_footer">
                        <a href="{{url('conta-bancaria')}}" class="btn btn-success btn-block">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card x_panel fixed_height_200">
                <div class="card-body  text-center">
                    <h4 class="card-title">Valor Atual <i class="fa fa-money"></i> </h4>
                    <h3>R$ 92.407,89</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card x_panel fixed_height_200">
                <div class="card-body  text-center">
                    <h3 class="card-title">Lançamento <i class="fa fa-pencil"></i> </h3>
                    <p class="card-text">Área exclusiva para realização de todos os lançamentos do mês, seja uma receita ou despesa.</p>
                    <div class="pricing_footer">
                        <a href="{{url('lancar')}}" class="btn btn-success btn-block">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card x_panel fixed_height_200">
                <div class="card-body  text-center">
                    <h4 class="card-title">Valor Atual <i class="fa fa-refresh"></i> </h4>
                    <p class="card-text">Rotina que irá criar caixa em cada mês de lançamento da igreja.</p>
                    <div class="pricing_footer">
                        <a href="{{url('caixa/routine')}}" class="btn btn-success btn-block">Abrir/Fechar Caixa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--	
    <div class="row">
        --}}
        {{--		
        <div class="col-md-12 col-sm-12 col-xs-12">
            --}}
            {{--			
            <div class="x_panel">
                --}}
                {{--				
                <div class="x_title">
                    --}}
                    {{--					<button class="btn btn-primary pull-right" onclick="companyTable.reloadTable()" data-toggle="tooltip" data-placement="bottom" data-original-title="Atualizar">--}}
                    {{--						<i class="fa fa-refresh" aria-hidden="true"></i>--}}
                    {{--					</button>--}}
                    {{--					
                    <div class="clearfix"></div>
                    --}}
                    {{--				
                </div>
                --}}
                {{--				
                <div class="x_content">
                    --}}
                    {{--					
                    <div class="table-responsive">
                        --}}
                        {{--						
                        <table class="table table-hover" id="company-table">
                            --}}
                            {{--							
                            <thead>
                                --}}
                                {{--								
                                <tr>
                                    --}}
                                    {{--									
                                    <th>Razão Social</th>
                                    --}}
                                    {{--									
                                    <th>Fantasia</th>
                                    --}}
                                    {{--									
                                    <th>Responsável</th>
                                    --}}
                                    {{--									
                                    <th>CNPJ</th>
                                    --}}
                                    {{--									
                                    <th>Data Cadastro</th>
                                    --}}
                                    {{--									
                                    <th>Aprovar</th>
                                    --}}
                                    {{--								
                                </tr>
                                --}}
                                {{--							
                            </thead>
                            --}}
                            {{--							
                            <tbody>--}}
                                {{--							
                            </tbody>
                            --}}
                            {{--						
                        </table>
                        --}}
                        {{--					
                    </div>
                    --}}
                    {{--				
                </div>
                --}}
                {{--			
            </div>
            --}}
            {{--		
        </div>
        --}}
        {{--	
    </div>
    --}}
</div>
<!-- /page content -->
</div>
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
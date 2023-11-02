@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.11/jquery.datetimepicker.min.css"
        rel="stylesheet">
<style>
   

</style>
@endpush
@section('main_container')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12">
                <div class="title-page-seara">
                    <div class="">
                        <h3>{{ $company->company_name }}                      
                        </h3>
                        <small class="badge badge-dark"> Código Igreja: {{$idCompany}}</small>
                        <input type="hidden" id="idCodeCompany" value="{{$idCompany}}">
                    </div>                    
                </div>
              
            </div>
            <div class="col-md-12">
                @if (is_null($boxOpen))
                <div class="alert alert-info alert-dismissible " role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h5>
                        <strong>Ops!</strong>
                        Você não tem registro de caixa aberto, então precisa abrir clicando, 
                        <a href="" class="btn btn-default">aqui</a>
                    </h5>
                    </div>
                @endif
            </div>
            <hr>
        </div>
        <div class="row">
            
            <!--
                    <div class="tile_count">
                        {{-- <div class="col-md-3 col-sm-6  tile_stats_count">
                <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Saldo Banco</span>
                <div class="count" id="bankBalance"></div>
                <span class="count_bottom text-info">Valores do caixa no banco</span>
            </div>
            <div class="col-md-3 col-sm-6  tile_stats_count">
                <span class="count_top text-success"><i class="fa fa-money  text-success"></i> Saldo Interno</span>
                <div class="count" id="internalBalance"></div>
                <span class="count_bottom text-success">Valores do caixa interno</span>
            </div> --}}
                    
                        <div class="col-md-3 col-sm-6  tile_stats_count">
                            <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Seu saldo atual de caixa</span>
                            <div class="count" id="generalBalance"></div>
                            {{-- <span class="count_bottom text-info">Seu valor atual de caixa geral</span> --}}
                        </div>
                    
                    </div>-->
            <div class="row" style="">
                <div class="tile_count">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                        <span class="count_top">
                            <i class="fa fa-university" aria-hidden="true"></i> Todos Banco
                        </span>
                        <div class="count">{{number_format($balanceBank, 2 , ',', '.')}}</div>
                        <span class="count_bottom">
                            <i class="green">
                                Valor geral de todos caixa banco
                            </i>
                        </span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                        <span class="count_top">
                            <i class="fa fa-money" aria-hidden="true"></i> Caixa Interno
                        </span>
                        <div class="count">{{number_format($internal, 2 , ',', '.')}}</div>
                        <span class="count_bottom">
                            <i class="green">
                                Valor geral do caixa interno
                            </i>
                        </span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                        <span class="count_top">
                            <i class="fa fa-calculator" aria-hidden="true"></i> Caixa Geral
                        </span>
                        <div class="count green">{{number_format($balanceGeneral, 2 , ',', '.')}}</div>
                        <span class="count_bottom">
                            <i class="green">
                                Valor geral de todos os caixas
                            </i>
                        </span>
                    </div>
    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel tile">
                        <div class="x_title">
                            <h2>LANÇAMENTO DE CAIXA <small>Seus últimos lançamentos</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                @role('admin|superAdmin')
                                <li class="dropdown">
                                    <div class="btn-group">
                                        <button 
                                            type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#lancar_conta"
                                            style="margin-right: 5px;"
                                        >
                                            Lançar Movimento
                                        </button>
                                      </div>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-dark">
                                        <a  href="{{url('lancar')}}" style="color: white;">
                                            <i class="fa fa-refresh"></i>
                                            Atualizar valores
                                        </a>
                                    </button>
                                </li>
                                @endrole
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                            @include('msg.message')
                            <div class="col-md-12">
                                <div class="col-md-2 col-xs-6">
                                    <label for="">Data Inicial</label>
                                    <input type="text" name="dateInitial" class="form-control date-mask" id="dateInitial">
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <label for="">Data Final</label>
                                    <input type="text" name="dateEnd" class="form-control date-mask" id="dateEnd">
                                </div>
                                <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <label class="col-md-12 col-sm-12 col-xs-12">Pesquisar</label>
                                            <button class="btn btn-primary" onclick="searchPeriod({{$idCompany}})">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <label class="col-md-12 col-sm-12 col-xs-12 ">Relatório</label>
                                            <a class="btn btn-default" id="btn-print-report" title="Imprime a consulta escolhida"
                                                onclick="showReport({{$idCompany}})">
                                                <i class="fa fa-print"></i> Imprimir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           </div>
                           <div class="row">
                                <div class="table-responsive">
                                <div class="clearfix"><hr></div>
                                <div class="col-md-12 col-xs-12">                                   
                                        <table id="entry-table" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Dia</th>
                                                    <th>Histórico</th>
                                                    <th>Valor</th>
                                                    <th>Tipo</th>
                                                    <th>Lançado por</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
    {{-- @include('modals.entry.modal_lauch') --}}
    @include('modals.modal_box_entry', ['saldo' => $internal, 'accountBank' => $accountBank])
    @include('modals.modal_upload_launch')
    @include('modals.entry.editLauch')
    {{-- EXCLUINDO UM LANCAMENTO --}}
    @component('components.modal_delete_comp')
    <form action="{{ url('lancar/delete') }}" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="alert alert-danger">
                <h4>
                    Deseja realmente excluir esse lançamento do caixa?
                </h4>
                <small>Essa ação é inreversível, não dá para voltar atrasasdás.</small>
            </div>
            <div class="text-center">
                <h4>Histórico: <label id="historyLaunchDeleteModal"></label></h4>
                <h4>Tipo: <label id="typeLaunchDeleteModal"></label> </h4>
                <p>
                    <label id="idParentLaunch" class="text-danger">

                    </label>
                </p>
            </div>
            <input type="hidden" name="id" id="idDelete">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="submit" class="btn btn-danger"> EXCLUIR </button>
            </div>
        </div>
    </form>
    @endcomponent
   <!-- Modal -->
<div class="modal fade" id="modalInfoLaunch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Informação completo do lançamento</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item day">Dia:</li>
                            <li class="list-group-item his">Histórico:</li>
                            <li class="list-group-item value">Valor:</li>
                            <li class="list-group-item account">Conta: </li>
                            <li class="list-group-item per">Criado:</li>
                        </ul>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label class="badge">Todos arquivos</label>
                        </div>
                        <div class="col-md-6">
                            @role('admin|superAdmin')
                            <a href="" class="btn btn-danger pull-right">Excluir arquivos</a>
                            @endrole
                        </div>
                        <div id="filesEntri">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
    
    <!-- /page content -->
@endsection
@push('stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/pt-br.min.js"
        integrity="sha512-1IpxmBdyZx3okPiZ14mzw6+pOGa690uDmcdjqvT310Kwv3NRcjvL/aOtoSprEyvkDdAb7ZtM2um6KrLqLOY97w=="
        crossorigin="anonymous"></script>
    <script>
        console.log(moment().format());
        var dtInit = moment().startOf('month').format("DD/MM/YYYY");
        var today = moment().endOf("month").format("DD/MM/YYYY");;
        $("#dateInitial").val(dtInit);
        $("#dateEnd").val(today);
        $("#inputDtInit").val(btoa(dtInit));
        $("#inputDtEnd").val(btoa(today));
    </script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/launch/entry.min.js') }}"></script>
    {{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.11/jquery.datetimepicker.full.min.js"
        integrity="sha512-hDFt+089A+EmzZS6n/urree+gmentY36d9flHQ5ChfiRjEJJKFSsl1HqyEOS5qz7jjbMZ0JU4u/x1qe211534g=="
        crossorigin="anonymous"></script>
@endpush

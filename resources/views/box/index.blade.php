@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->{{-- 
{{Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css')}} --}}
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12">
    
            @include('msg.message');

            <div class="x_panel">
                <div class="x_title">
                    <h2>Caixa <small>Registrar Caixa</small></h2>

                    <a class="btn btn-app pull-right" data-toggle="modal" data-target="#create_account">
                        <i class="fa fa-list-ol" aria-hidden="true"></i> Criar Conta
                    </a>
                    @include('modals.modal_account')
                    <div class="clearfix"></div>
                     <strong>MÊS / ANO: </strong>{{ \Carbon\Carbon::now()->month . ' / '. \Carbon\Carbon::now()->year }}
                </div>
                <div class="col-md-12">
                    @if(empty($box))
                        @php
                        $disabled = 'disabled';
                        @endphp
                    @else
                        @php
                        $disabled = '';
                        @endphp   
                    @endif

                    <a href="#lancar_conta" data-toggle="modal">
                        <button class="btn btn-primary pull-right {{$disabled}}" {{$disabled}}> 
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Lançar registro
                        </button>
                    </a>

                   @if(count($box) == 0 )
                        <a href="#modal_open_box" data-toggle="modal"><button class="btn btn-success pull-left"> <i class="fa fa-money" aria-hidden="true"></i> Abrir caixa</button></a>
                    @else
                        <a href="#modal_close_box" data-toggle="modal"><button class="btn btn-success pull-left"> <i class="fa fa-money" aria-hidden="true"></i> Fechar caixa</button></a>
                    @endif
  @include('modals.modal_open_box')

                    <div class="col-md-12">
                        <div class="panel">
                            @php
                                global $soma_total;
                                $soma_total = 0;

                            @endphp
                            @if(count($entry) == 0)
                                @php
                                $previus_balance = 0;
                                @endphp
                            @else

                                @foreach($entry as $entries)

                                @php

                                $soma_total = ($soma_total + $entries->entries_decimate);
                                $soma_total = ($soma_total + $entries->entries_offer);
                                $soma_total = ($soma_total + $entries->entries_other);
                                $soma_total = ($soma_total - $entries->entries_end);

                                @endphp    
                            @endforeach
                            
                            @endif   
                                @php
                                    if(count($box) == 0)
                                    {
                                        $boxies_balance_initial = 0;
                                    }else{
                                        $boxies_balance_initial = $box[0]->boxies_balance_initial;
                                    } 

                                $previus_balance = ($boxies_balance_initial + $soma_total);
                                @endphp 
                            <div class="col-md-12">
                              <div class="col-md-4">
                                 <div class="x_title">
                                  <h2>Saldo Atual: R$  {{number_format($previus_balance, 2 , ',' , '.')}} </h2>
                                  <ul class="nav navbar-right panel_toolbox">

                                    <li><a href="{{url('caixa')}}" class="close-link"><i class="fa fa-refresh text-primary"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                       
                            <h4>Caixa aberto em: 
                            @if(count($box)  == 0)
                                {{''}}
                            @else
                                {{date('d/m/Y' , strtotime($box[0]->boxies_date_open))}}
                            @endif
                            </h4>
                            
                        </div>
                        <div class="col-md-4">
                             <h4>Saldo Anterior: 
                                {{(count($value_previous) > 0 ? $value_previous[0]->boxies_balance_end : '')}}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="x_content">
            <div class="panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="table_launch" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Descrição</th>
                                    <th>Dízimo</th>
                                    <th>Oferta</th>
                                    <th>Outros</th>
                                    <th>Saída</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
        @include('modals.modal_box_entry');
        @include('modals.modal_delete_launch');
        @include('modals.modal_close_box')



    </div>
</div>
</div>
</div>

<!-- /page content -->
@endsection

@push('scripts')


{{Html::script('plugins/bootstrap-daterangepicker/moment.min.js')}}
{{Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js')}}
<script src="{{ asset('js/mask.min.js') }}"></script>
<script src="{{ asset('js/box.min.js') }}"></script>

@endpush
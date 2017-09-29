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
    
            @include('msg.message')

            <div class="x_panel">
                <div class="x_title">
                    <h2>Caixa <small>Registrar Caixa</small></h2>

                    <a class="btn btn-app pull-right" data-toggle="modal" data-target="#create_account">
                        <i class="fa fa-list-ol" aria-hidden="true"></i> Criar Conta
                    </a>
                    <a class="btn btn-success pull-right" data-toggle="modal" data-target="#view_all">
                        <i class="fa fa-list" aria-hidden="true"></i> Todas Contas
                    </a>
                    @include('modals.modal_account')
                    
                    <!-- -->
                    
                    <div class="modal fade" id="view_all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">TODAS AS CONTAS</h4>
                          </div>
                          <div class="modal-body">
                           @push('scripts')
                                 <script type="text/javascript">

                                $.get(url_project+'/mostrar-contas', function(data) {
                                    /*optional stuff to do after success */
                                    $.each(data, function(index, value) {
                                        console.log( value.length);
                                        for (var i = 0; i < value.length; i++) {
                                            console.log( value[i].accounts_name);
                                            $("#data-account").append('<li class="list-group-item"> CODIGO: '+value[i].accounts_id+' - '+value[i].accounts_name+'</li>')
                                        }
                                    });
                                });
                                
                            </script>
                           @endpush
                           <ul class="list-group" id="data-account">
                              
                            </ul>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- fim todas as contas -->
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
                    <a href="#modal_open_box" data-toggle="modal"><button class="btn btn-default pull-left"> <i class="fa fa-print" aria-hidden="true"></i> Imprimir caixa</button></a>
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
                        <table id="table_launch" class="display dataTable" cellspacing="0" width="100%">
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
                            <tbody>
                                @foreach ($entry as $entries)
                                    <tr>
                                        <td>{{$entries->entries_day}}</td>
                                        <td>{{$entries->entries_description}}</td>
                                        <td>{{number_format($entries->entries_decimate, 2 , ',' , '.')}}</td>
                                        <td>{{number_format($entries->entries_offer, 2 , ',' , '.')}}</td>
                                        <td>{{number_format($entries->entries_other, 2 , ',' , '.')}}</td>
                                        <td>{{number_format($entries->entries_end, 2 , ',' , '.')}}</td>
                                        <td>
                                           <a href="#alter_entry_{{$entries->entries_id}}" class="btn btn-default"  data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                           <a href="#delete_entries_{{$entries->entries_id}}" class="btn btn-danger"  data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></a>     
                                        </td>
                                    </tr>
                                    <!-- Modal deletar lançamento -->
                                    @php
                                        $modal_id_delete = 'delete_entries_'.$entries->entries_id;
                                        $description_modal = "Apagar Lançamento";
                                        $url_route = 'lancar/'.$entries->entries_id;
                                        $text_delete = "Deseja realmente excluir esse lançamento?";
                                        $name_camp = "entries_id";
                                        $value_camp = $entries->entries_id;
                                    @endphp
                                    @include('modals.modal_alter_entry')
                                    @include('modals.modal_delete')
                                @endforeach
                                <tr>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
        @include('modals.modal_box_entry')
        @include('modals.modal_delete_launch')
        @include('modals.modal_close_box')
        @include('modals.modal_load')


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
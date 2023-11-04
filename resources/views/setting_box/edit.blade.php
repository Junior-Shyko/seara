@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.11/jquery.datetimepicker.min.css"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@section('main_container')
    <div class="right_col" role="main" style="min-height: 948px;">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Editar de caixa</h3>
                </div>
                <div class="title_right">

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Caixa</h2>

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                        aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Settings 1</a>
                                        <a class="dropdown-item" href="#">Settings 2</a>
                                    </div>
                                </li>
                                <li>
                                    <a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                    <tbody>
                                    <tr>
                                    <th >Data da abertura:</th>
                                    <td>{{\Carbon\Carbon::parse($setBox->data_open)->format('d/m/Y H:i:d')}}</td>
                                    </tr>
                                    <tr>
                                    <th>Aberto por:</th>
                                    <td>{{$setBox->name}}</td>
                                    </tr>
                                    <tr>
                                    <th>Situação:</th>
                                    <td>
                                        {{$setBox->slug == 'open' ? 'Aberto' : 'Fechado'}}
                                    </td>
                                    </tr>
                                    <tr>
                                    <th>Mês de Referência:</th>
                                    <td>{{\Carbon\Carbon::parse($setBox->data_open)->month}}</td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    @include('msg.message')
                                </div>
                                <form id="form-edit-box" data-parsley-validate="" method="POST" action="{{ url('caixa') }}"
                                    class="form-horizontal form-label-left" novalidate="">
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Data da
                                            abertura
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="data_open_box" class="form-control" 
                                                placeholder="dd/mm/aaaa"
                                                type="text" required="required"
                                                name="data_open"
                                                value="{{\Carbon\Carbon::parse($setBox->data_open)->format('d/m/Y H:i:d')}}">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Data do
                                            fechamento
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="data_close_box_edit" class="date-picker form-control"
                                            placeholder="dd/mm/aaaa" type="text" name="data_close">
                                            <p class="text-muted" style="color: darkgoldenrod;">Para fechar o caixa, basta preencher a data do fechamento.</p>
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="item form-group">
                                        
                                        <div class="col-md-6">
                                            <a href="{{url('caixa')}}" class="btn btn-default pull-left" title="Altera e/ou fecha o caixa">
                                                <i class="fa fa-arrow-circle-left"></i> Voltar
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-sm-6 offset-md-3">
                                            <input type="hidden" name="id_user_open" value="{{ Auth::user()->id }}">
                                            <button type="button" onClick="alterarCaixa({{$setBox->id}})" class="btn btn-success pull-right" title="Altera e/ou fecha o caixa">
                                                <i class="fa fa-money"></i> Alterar Caixa
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>
                            <br>
                            <div class="clearfix"></div>
                            
                           
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush
@push('scripts')
    <script type="text/javascript" language="javascript" src="{{ asset('js/setting_box/setting-box.js') }}"></script>
@endpush

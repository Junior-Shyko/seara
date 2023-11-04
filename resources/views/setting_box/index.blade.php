@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="{{asset('css/setting-box.css')}}"  rel="stylesheet">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.11/jquery.datetimepicker.min.css"
rel="stylesheet"> --}}
@endpush
@section('main_container')
    <div class="right_col" role="main" style="min-height: 948px;">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Configuração de caixas</h3>
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
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    @include('msg.message')
                                </div>
                                <form id="demo-form2" data-parsley-validate="" method="POST" action="{{ url('caixa') }}"
                                    class="form-horizontal form-label-left" novalidate="">
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Data da
                                            abertura
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="date_open_box" class="form-control" placeholder="dd/mm/aaaa"
                                                type="text" required="required" name="date_open" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="item form-group">
                                        <div class="col-md-6 col-sm-6 offset-md-3">
                                            <input type="hidden" name="id_user_open" value="{{ Auth::user()->id }}">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-money"></i> Abrir Caixa
                                            </button>
                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>
                            <br>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <a href="" class="btn btn-primary btn-block">
                                            Reabrir multiplo caixas
                                        </a>
                                    </div>
                                    <div class="col-md-4"></div>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_settings_box">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>Data Abertura</th>
                                            <th>Data Fechamento</th>
                                            <th>Aberto por</th>
                                            <th>Fechado por</th>
                                            <th>Ação</th>
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
@endsection
@push('stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush
@push('scripts')
<script type="text/javascript" language="javascript" src="{{ asset('js/setting_box/setting-box.js') }}"></script>

@endpush

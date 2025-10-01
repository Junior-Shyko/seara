@extends('layouts.blank')

@push('stylesheets')
    <style>


    </style>
@endpush

@section('main_container')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Financeiro</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <i class="fa fa-bar-chart"></i>
                        Relatório Financeiro
                        <br>
                        <div class="clearfix">
                            <br>
                        </div>
                        <form action="{{url('relatorio/gerar-financeiro/')}}" data-parsley-validate="" 
                            method="GET" class="form-horizontal form-label-left" novalidate="">

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Qual o mês?
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <select name="month_financial" id="month_financial" class="form-control">
                                        <option value="0">-- Selecione o mês --</option>
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="year_financial">Digite o
                                    ano<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6  form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="year_financial"
                                        name="year_financial" placeholder="Últimos dígitos do ano">
                                    <span class="form-control-feedback left" aria-hidden="true">20</span>
                                </div>
                            </div>
                            <div class="item form-group">

                            </div>
                            <div class="item form-group">

                            </div>
                            <div class="item form-group">
                                <input type="text" name="company_id" value="{{ Auth::user()->user_id_company }}" hidden>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-4 col-sm-4 offset-md-3"></div>

                                <div class="col-md-4 col-sm-4 offset-md-3">
                                    <button class="btn btn-primary" type="button">Desistir</button>
                                    <button type="submit" class="btn btn-success">Gerar Relatório</button>
                                </div>

                                <div class="col-md-4 col-sm-4 offset-md-3"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#month-year-picker').mask('00', {
                placeholder: "__"
            });
        });
    </script>
@endpush

@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.11/jquery.datetimepicker.min.css"
        rel="stylesheet">
@endpush
@section('main_container')
<div class="right_col" role="main" style="min-height: 948px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Conta Bancaria</h3>
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Criar conta bancaria</h2>
                        <a href="#" title="Lançar movimento no caixa" class="btn btn-primary navbar-right">
                            Lançar Movimento
                        </a>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-4 col-sm-12  form-group">
                                <label for="">Banco</label>
                                <select name="" id="" class="form-control select2">
                                    <option value="">--selecione--</option>
                                    <option value="">Opção A</option>
                                    <option value="">Opção B</option>
                                    <option value="">Opção C</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                                <label for="">Tipo de conta bancaria</label>
                                <select name="" id="" class="form-control select2">
                                    <option value="">--selecione--</option>
                                    <option value="">Tipo A</option>
                                    <option value="">Tipo B</option>
                                    <option value="">Tipo C</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                                <label for="">Valor</label>
                                <input type="text" placeholder=".col-md-12" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12  form-group">
                                <label for="">Número da conta</label>
                                <input type="text" placeholder=".col-md-12" class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                                <label for="">Número da agência</label>
                                <input type="text" placeholder=".col-md-12" class="form-control">
                            </div>
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
@endpush

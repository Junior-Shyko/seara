@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="tile_count">
            <div class="col-md-3 col-sm-6  tile_stats_count">
                <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Caixa Banco</span>
                <div class="count">254</div>
                <span class="count_bottom text-info">Valores do caixa desse mês</span>
            </div>
            <div class="col-md-3 col-sm-6  tile_stats_count">
                <span class="count_top text-success"><i class="fa fa-money  text-success"></i> Caixa</span>
                <div class="count">2545</div>
                <span class="count_bottom text-success">Valores do mês atual</span>
            </div>
            <div class="col-md-3 col-sm-6  tile_stats_count">
                <span class="count_top text-info"><i class="fa fa-money  text-info"></i> Caixa Geral</span>
                <div class="count">5484</div>
                <span class="count_bottom text-info">Valores do mês atual</span>
            </div>
        </div>
    </div>
    <div class="x_panel">
        @include('msg.message')
        <div class="x_title">
            <h2>ALTERAR LANÇAMENTO {{$id}}<small>Altere o registro ou os arquivos.</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="right-col">
                <div class="row">
                    <form action="{{url('lancar/'.$id)}}" method="POST" >
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Conta:</label>
                            <select name="entries_id_account" id="cod_account" class="form-control select2">
                                <option value=""></option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->accountlaunch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Tipo de conta:</label> <br>
                            <h4 class="control-label text-primary" id="label_desc_type">
                                <strong>{{$launch[0]->account_types_name}}</strong>
                            </h4>
                        </div>
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Dia:</label>
                            <div class="form-group has-feedback" id="divActualLaunch">
                                {{Form::selectRange('entries_day', 01, 31, $launch[0]->entries_day, ['class' =>'form-control' , 'id' => 'entries_day'])}}
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-6 form-group">
                            <label for="">Histórico:</label>
                            <input type="text"  name="entries_description" class="form-control" value="{{$launch[0]->entries_description}}">
                        </div>
                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="">Valor:</label>
                            <input type="text" class="form-control" name="entries_value" value="{{$launch[0]->entries_value}}">
                        </div>
                        <div class="col-md-8 col-sm-6 form-group">
                            <label for="">Tipo de caixa:</label>
                            <div class="">
                                <label class="btn btn-primary">
                                <input type="radio" class="flat" checked name="iCheck"> Banco
                                </label>
                                <label class="btn btn-primary">
                                <input type="radio" class="flat" name="iCheck"> Local
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <hr>
                            <div class="form-group pull-right">
                                <button type="button" class="btn btn-default">
                                <i class="fa fa-close"></i>
                                Sair
                                </button>
                                <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>
                                Salvar alteração
                                </button>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
                {{-- IMAGENS  --}}
                <div class="row">
                    <div class="x_title">
                        <h2>Arquivos {{$id}}<small>Todos os arquivos enviados.</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
@push('stylesheets')
{{-- 
<link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
--}}
@endpush
@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/launch/entry.min.js')}}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
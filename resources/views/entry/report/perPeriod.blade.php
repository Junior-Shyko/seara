@extends('layouts.report.layout')
@push('stylesheets')
<style>
   
</style>
<!-- Example -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

@endpush
@section('main_container')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            {{$entries[0]->company_name}}
            <caption class="text-center">Movimento do caixa</caption>
        </div>
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th>
                        <label for="">Período: {{$perInitial}} até {{$perEnd}}</label>
                    </th>
                    <th>
                        <label for="">Saldo: {{number_format($total, 2, ',', '.')}}</label>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Conta</th>
                    <th>Histórico</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Caixa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>2021-03-13 00:00:00</th>
                    <td>20</td>
                    <td>Recebimento de oferta de missões</td>
                    <td>Receita</td>
                    <td>200.0</td>
                    <td>0</td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('stylesheets')
{{-- 
<link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}">
--}}
@endpush
@push('scripts')
{{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush
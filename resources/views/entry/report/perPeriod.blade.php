@extends('layouts.report.layout')
@push('stylesheets')
<style>
   .title-company {
    padding: 5px;
    margin: 5px;
    border: 1px solid #c5c5c5;
    width: 100%;
}
</style>
<!-- Example -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >


@endpush
@section('main_container')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <label class="title-company">{{$entries[0]->company_name}}</label>
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
                @foreach ($entries as $entry)
                <tr>
                    <th style="width: 10%">
                        {{ \Carbon\Carbon::parse($entry->entries_date_launch)->format('d/m/Y')}} 
                    </th>
                    <td>{{$entry->accountlaunch_name}}</td>
                    <td>{{$entry->accountlaunch_history}}</td>
                    <td style="width: 10%">{{$entry->account_types_name}}</td>
                    <td>{{ number_format($entry->entries_value,2,',','.') }}</td>
                    @if ($entry->entries_bank == 0)
                        <td style="width: 10%">Interno</td>
                    @else
                        <td style="width: 10%">Banco</td>
                    @endif
                </tr>
                @endforeach
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
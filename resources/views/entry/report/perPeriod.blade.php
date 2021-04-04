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
                    
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Histórico</th>
                    <th>Receita</th>
                    <th>Despesa</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">
                        <label for="">
                            Saldo Anterior
                        </label>
                    </td>
                    <td colspan="2">
                        {{number_format($previousBalance,2,',','.')}}
                    </td>
                </tr>
                @php 
                $balance = 0;
                @endphp
                @foreach ($entries as $key => $entry)
                
                <tr>
                    <th style="width: 10%">
                        {{ \Carbon\Carbon::parse($entry->entries_date_launch)->format('d/m/Y')}} 
                    </th>
                    <td>{{$entry->accountlaunch_history}}</td>
                    <td>
                        @if ($entry->account_types_name == "Receita")
                        {{ number_format($entry->entries_value,2,',','.') }}
                        @endif
                    </td>
                    <td>
                        @if ($entry->account_types_name == "Despesa")
                        {{ number_format($entry->entries_value,2,',','.') }}
                        @endif
                    </td>
                    <td>
                    @if ($key == 0)
                        @if ($entry->account_types_name == "Receita")
                            @php
                                $balance = ($balance + $previousBalance + $entry->entries_value);
                                echo number_format($balance,2,',','.');
                            @endphp
                        @else
                            @php
                                $balance = ( $balance + $previousBalance - $entry->entries_value);
                                echo number_format($balance,2,',','.');
                            @endphp
                        @endif
                    @else
                        @if ($entry->account_types_name == "Receita")
                            @php
                            $balance = ($balance + $entry->entries_value);
                                //echo $key.'- '.$balance.' - '. $entry->entries_value;
                                echo number_format($balance,2,',','.');
                            @endphp
                        @else
                            @php
                                $balance = ( $balance - $entry->entries_value);
                                echo number_format($balance,2,',','.');
                            @endphp
                        @endif
                    @endif
                    </td>
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
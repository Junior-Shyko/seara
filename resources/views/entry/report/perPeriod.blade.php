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
<style>
    .smallPeriod {
        font-size: 10px;
    }
    .center-text{
        text-align: center;
    }
    .title-table{
        background: #f0e6e6;
        color: rgb(15, 14, 14);
        font-family: Arial, Helvetica, sans-serif;
        border: 1px solid #c3c3c3;
    }
    .margin5 {
        margin-left: 5px;
    }
    .border-table {
        font-size: 0.90em; border-bottom: 1px solid black;
    }
</style>

@endpush
@section('main_container')
<div class="container">
    <div class="row">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="5" style="border: 1px solid black; border-radius: 5px;" class="center-text">
                        <label>{{$entries[0]->company_name}}</label>
                    </th>
                </tr>
                <tr>
                    <th  colspan="5" class="center-text" style="border-bottom: 1px solid black;">
                        <caption  style="color: #423f3f">Movimento do caixa</caption>
                    </th>
                </tr>
                <tr>
                    <th colspan="5"  style="padding: 5px;">
                        <small class="smallPeriod">Período: <strong>{{$perInitial}}</strong> até <strong>{{$perEnd}}</strong></small>
                    </th>
                </tr>
                
                <tr>
                    <th class="title-table" style="width: 5px;"><label class="margin5">Data</label></th>
                    <th class="title-table" style="width: 300px;"><label class="margin5">Histórico</label></th>
                    <th class="title-table"><label class="margin5 ">Receita</label></th>
                    <th class="title-table"><label class="margin5">Despesa</label></th>
                    <th class="title-table"><label class="margin5">Saldo</label></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="border-table">
                        <label for="">
                            Saldo Anterior
                        </label>
                    </td>
                    <td class="center-text border-table">
                        {{number_format($previousBalance,2,',','.')}}
                    </td>
                </tr>
                @php 
                $balance = 0;
                $recipes = 0;//receitas
                $expenses= 0;//despesas
                $total   = 0;
                @endphp
                @foreach ($entries as $key => $entry)
                <tr>
                    <th style="width: 10%;" class="border-table">
                        {{ \Carbon\Carbon::parse($entry->entries_date_launch)->format('d/m/Y')}} 
                    </th>
                    <td  class="border-table">{{$entry->accountlaunch_history}}</td>
                    <td class="center-text border-table">
                        @if ($entry->account_types_name == "Receita")
                        {{ number_format($entry->entries_value,2,',','.') }}
                        @php $recipes = ($recipes + $entry->entries_value); @endphp
                        @endif
                    </td>
                    <td class="center-text border-table">
                        @if ($entry->account_types_name == "Despesa")
                        {{ number_format($entry->entries_value,2,',','.') }}
                        @php $expenses = ($expenses + $entry->entries_value); @endphp
                        @endif
                    </td>
                    <td class="center-text border-table">
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
                
                <tr>
                    <td colspan="2"  class="title-table">
                        <label for="">
                            Totais do período
                            <span class="smallPeriod">(s.ant + ent + sai)</span>
                        </label>
                        
                    </td>
                    <td class="center-text title-table">
                        @php echo number_format($recipes,2,',','.'); @endphp
                    </td>
                    <td class="center-text title-table">
                        
                        @php echo number_format($expenses,2,',','.'); @endphp
                    </td>
                    <td class="center-text title-table">
                        @php 
                            $total = ($previousBalance + $recipes - $expenses);
                            echo '<strong>'.number_format($total,2,',','.').'</strong>';
                        @endphp
                    </td>
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
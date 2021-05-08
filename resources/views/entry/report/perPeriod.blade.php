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
<style>
    .smallPeriod {
        font-size: 10px;
    }
</style>

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
                        <small class="smallPeriod">Período: {{$perInitial}} até {{$perEnd}}</small>
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
                    <th class="text-center">Receita</th>
                    <th class="text-center">Despesa</th>
                    <th class="text-center">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3">
                        <label for="">
                            Saldo Anterior
                        </label>
                    </td>
                    <td colspan="2"  class="text-right">
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
                    <th style="width: 10%">
                        {{ \Carbon\Carbon::parse($entry->entries_date_launch)->format('d/m/Y')}} 
                    </th>
                    <td>{{$entry->accountlaunch_history}}</td>
                    <td class="text-center">
                        @if ($entry->account_types_name == "Receita")
                        {{ number_format($entry->entries_value,2,',','.') }}
                        @php $recipes = ($recipes + $entry->entries_value); @endphp
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($entry->account_types_name == "Despesa")
                        {{ number_format($entry->entries_value,2,',','.') }}
                        @php $expenses = ($expenses + $entry->entries_value); @endphp
                        @endif
                    </td>
                    <td class="text-center">
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
                    <td colspan="2">
                        <label for="">
                            Totais do período
                            <span class="smallPeriod">(s.ant + ent + sai)</span>
                        </label>
                        
                    </td>
                    <td class="text-center">
                        @php echo number_format($recipes,2,',','.'); @endphp
                    </td>
                    <td class="text-center">
                        
                        @php echo number_format($expenses,2,',','.'); @endphp
                    </td>
                    <td class="text-center">
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
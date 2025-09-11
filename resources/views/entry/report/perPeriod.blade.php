<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatorio geral - Seara Contabilidade</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <title>Relatório de caixa - @yield('title')</title>
    <style>
        section {
            display: table;
            width: 100%;
        }

        section>* {
            display: table-row;
        }

        section .col {
            display: table-cell;
        }

        section .col-right {
            display: table-cell;
            float: right;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            border: 1px solid;
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
    </style>

</head>
<body>
<section>
    <header>
        <div class="col">
            <small>
                Seara Contabilidade <br>
                Empresa: {{$entries[0]->company_name}} - CNPJ: {{$entries[0]->company_cnpj}} <br>
                Período: {{$perInitial}} a {{$perEnd}} <br>
            </small>
        </div>
        <div class="col-right"></div>
    </header>
    <header>
        <div class="col"></div>
    </header>

</section>
<br>
<table style="width: 100%;" border="1" cellpadding="1">
    <thead>
    <tr>
        <th  colspan="5" class="center-text" style="border-bottom: 1px solid black;">
            <caption  style="color: #423f3f">Movimento do caixa</caption>
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

    @endphp

    @foreach ($entries as $key => $entry)
       <tr>
         {{--PRIMEIRA COLUNA--}}
            <th style="width: 10%;" class="border-table">
                <small>
                    {{ \Carbon\Carbon::parse($entry->entries_date_launch)->format('d/m/Y')}}
                </small>
            </th>
        {{--SEGUNDA COLUNA----}}
            <td  class="border-table">               
                @if($entry->accountlaunch_name === "Transferência" || $entry->accountlaunch_name === "Transferência bancária")
                    {{$entry->entries_description}}
                @else
                    {{$entry->accountlaunch_history}}
                @endif
               
            </td>
        {{--TERCEIRA COLUNA--}}
            <td class="center-text border-table">
              
                @if ($entry->account_types_name == "Receita")
                    {{ number_format($entry->entries_value,2,',','.') }}
                    @php
                        if($entry->accountlaunch_name == 'Transferência bancária' || $entry->accountlaunch_name == 'Transferência')
                        {
                            //não soma valor de transferência como receita
                            $recipes = ($recipes + 0);                           
                        }else{
                             $recipes = ($recipes + $entry->entries_value); 
                        }                  
                   @endphp
                @endif
                {{-- Lançamento de transferência que entra no caixa mas como receita--}}
                {{-- Parente > 0 significa que entrou valor --}}
                @if (
                    ($entry->accountlaunch_name === "Transferência bancária" ||
                    $entry->accountlaunch_name === "Transferência") &&
                    $entry->entries_parent > 0)
                    {{ number_format($entry->entries_value,2,',','.') }}
                @endif
               
            </td>
        {{-- QUARTA COLUNA --}}
            <td class="center-text border-table">
                @if ($entry->account_types_name == "Despesa")
                    {{ number_format($entry->entries_value,2,',','.') }}
                    @php $expenses = ($expenses + $entry->entries_value); @endphp
                @endif
                @if (
                    $entry->account_types_name == "Transferência" && 
                    $entry->accountlaunch_name == "Transferência" &&
                    $entry->entries_parent === -1)
                    {{ number_format($entry->entries_value,2,',','.') }}
                @endif
            </td>
            {{-- QUINTA COLUNA--}}
            <td class="center-text border-table">
                @if ($key == 0)
                    @if ($entry->account_types_name == "Receita")
                        @php
                            $balance = ($balance + $previousBalance + $entry->entries_value);
                            echo number_format($balance,2,',','.');
                        @endphp
                    @endif

                    @if($entry->account_types_name == "Despesa")
                        @php
                            $balance = ( $balance + $previousBalance);
                        @endphp
                    @endif
                @endif
                @if ($entry->account_types_name == "Receita")
                    @php
                        $balance = ($balance + $entry->entries_value);
                        echo number_format($balance,2,',','.');
                    @endphp
                @endif
                @if($entry->account_types_name == "Despesa")
                    @php
                        $balance = ( $balance - $entry->entries_value);
                        echo number_format($balance,2,',','.');
                    @endphp
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
                $total = ($previousBalance + $recipes) - $expenses;
                echo '<strong>'.number_format($total,2,',','.').'</strong>';
            @endphp
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
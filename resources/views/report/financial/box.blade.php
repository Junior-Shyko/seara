@extends('layouts.report.layout')
@push('stylesheets')
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>

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
            font-size: small;
            padding: 0.35rem
        }


        .center-text {
            text-align: center;
        }

        .title-table {
            background: #f0e6e6;
            color: rgb(15, 14, 14);
            font-family: Arial, Helvetica, sans-serif;
            border: 1px solid #c3c3c3;
        }
    </style>
@endpush
@section('main_container')
    <section style="padding: 5px;">
        <header>

            <div class="col">
                <small>
                    Seara Contabilidade <br>
                    Empresa: {{ $company->company_name }} - CNPJ: {{ $company->company_cnpj }} <br>
                    @if($perInitial == '' && $perEnd == '')
                        Período: Todos os lançamentos
                    @else
                     Sem período
                        @endif
                     <br>
                </small>
            </div>
            <div class="col-right"></div>
        </header>
        <header>
            <div class="col"></div>
        </header>

    </section>
    <br>
    <table style="width: 100%;">
        <tr>
            <th class="center-text" style="border-top: 1px solid black;">
                <caption style="color: #423f3f">Movimento do caixa</caption>
            </th>
        </tr>
    </table>

    <div class="container">
        <div>
            <br>
        </div>
        @if ($entries->isEmpty())
            <p>Nenhum lançamento encontrado.</p>
        @else
            <table class="table table-striped">
                <thead>
                     @if (isset($priorBalance) && $perInitial && $perEnd)
                     <tr>
                        <th colspan="5">
<strong>Saldo Anterior ao Período:</strong> R$ {{ number_format($priorBalance, 2, ',', '.') }}
                        </th>
                     </tr>
                             @endif
                    <tr>
                        <th>DATA</th>
                        <th>HISTORICO</th>
                        <th>RECEITA</th>
                        <th>DESPESA</th>
                        <th>SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}</td>
                            
                            <td>{{ $entry->description }}</td> 
                            <td>
                                @if ($entry->type === 'credit')
                                    {{ number_format($entry->amount, 2, ',', '.') }} 
                                @else
                                    0,00
                                @endif
                            </td>
                            <td>
                                @if ($entry->type === 'debit')
                                    {{ number_format($entry->amount, 2, ',', '.') }}
                                @else
                                    0,00
                                @endif
                            </td>
                            <td>{{ number_format($entry->running_balance, 2, ',', '.') }}</td> <!-- Saldo acumulado -->
                        </tr>
                    @endforeach
                    <tr style="font-weight: 500;font-size: small;background-color: #f0f0f0;">
    <td colspan="2">Totais do período (s.ant + ent + sai)</td> <!-- Ajuste o colspan conforme o número de colunas da sua tabela -->
    
    <td>Total: {{ number_format($totalCredits, 2, ',', '.') }}</td>
    <td>Total: {{ number_format($totalDebits, 2, ',', '.') }}</td>
    <td>Geral: {{ number_format($priorBalance + $totalCredits - $totalDebits, 2, ',', '.') }}</td>
</tr>
                </tbody>
            </table>
        @endif
            @if (!$entries->isEmpty())
        <p><strong>Saldo Final:</strong> R$ {{ number_format($entries->last()->running_balance, 2, ',', '.') }}</p>
    @endif
    </div>

@endsection

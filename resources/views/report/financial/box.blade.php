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
            font-size: small
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
<div class="container">
        <h1>Relatório de Lançamentos Financeiros</h1>
        
        @if ($entries->isEmpty())
            <p>Nenhum lançamento encontrado.</p>
        @else
            <table class="table table-striped">
                <thead>
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
                            <td>{{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}</td> <!-- Formata a data; ajuste o formato -->
                            <td>{{ $entry->description }}</td> <!-- Assumi 'description' como campo de histórico -->
                            <td>
                                @if ($entry->type === 'credit')
                                    {{ number_format($entry->amount, 2, ',', '.') }} <!-- Formata como moeda; ajuste -->
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
                </tbody>
            </table>
        @endif
    </div>

</body>
</html>
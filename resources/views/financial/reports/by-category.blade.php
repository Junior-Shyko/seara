<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatorio geral de contas - Seara Contabilidade</title>
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
        }

        .ml-5 {
            margin-left: 5px;
            font-size: small;
        }

        .td-launch {
            color: #4f4f4f !important;
        }

        .float-r {
            float: right;
        }

        .bg-tot {
            background: #dfdede
        }

        .bg-balance {
            background: #f3f3f3
        }

        .tr-center {
            text-align: center;
        }
    </style>

</head>

<body>
    <section>
        <header>
            <div class="col">
                <small>
                    Empresa: <br>
                    CNPJ:
                </small>
            </div>
            <div class="col-right"></div>
        </header>
        <header>
            <div class="col">Período: {{ $report['period']['start'] }} a {{ $report['period']['end'] }}</div>
            <div class="col-right">Seara Contabilidade</div>
        </header>

    </section>
    <br>
<table style="width: 100%;" border="1" cellpadding="1">
    <thead>
        <tr class="bg-light">
            <th class="text-center">Data</th>
            <th class="text-center">Descrição</th>
            <th class="text-right">Receita</th>
            <th class="text-right">Despesa</th>
            <th class="text-right">Valor Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $balance = 0;
        @endphp
        
        @foreach ($report['entries_by_category'] as $categoryGroup)
            {{-- Cabeçalho da Categoria --}}
            <tr style="background-color: #edf4fa;">
                <td colspan="5">
                    <strong>Conta : </strong>{{ $categoryGroup['category_name'] }} -
                    {{ $categoryGroup['count'] }} lançamento(s)
                </td>
            </tr>
            
            {{-- Lançamentos da Categoria --}}
            @foreach ($categoryGroup['entries'] as $entry)
                <tr>
                    <td>{{ $entry['date'] }}</td>
                    <td>{{ $entry['description'] }}</td>
                    <td class="text-center">
                        @if ($entry['type'] === 'credit')
                            <span class="badge badge-success">
                                {{ number_format($entry['amount'], 2, ',', '.') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($entry['type'] === 'debit')
                            <span class="badge badge-danger">
                                {{ number_format($entry['amount'], 2, ',', '.') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($entry['type'] === 'credit')
                            @php
                                $balance += $entry['amount'];
                            @endphp
                        @else
                            @php
                                $balance -= $entry['amount'];
                            @endphp
                        @endif
                        {{ number_format($balance, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            
            {{-- Subtotal da Categoria --}}
            <tr style="background-color: #f1f3f5;">
                <td colspan="4" class="text-right" style="font-size: small;">
                    <strong>Resumo da conta {{ $categoryGroup['category_name'] }}:</strong>
                </td>
                <td class="text-right">
                    <strong class="{{ $categoryGroup['subtotal'] >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $categoryGroup['subtotal_formatted'] }}
                    </strong>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
        @endforeach
    </tbody>
    
    {{-- Total Geral (fora do loop) --}}
    <tfoot class="bg-light">
        <tr>
            <td colspan="4" class="text-right"><strong>TOTAL GERAL:</strong></td>
            <td class="text-right">
                <strong class="{{ $report['totals']['balance_class'] }}">
                    {{ $report['totals']['balance_formatted'] }}
                </strong>
            </td>
        </tr>
    </tfoot>
</table>

</body>

</html>

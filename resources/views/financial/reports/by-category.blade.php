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
        }

        .ml-5 {
            margin-left: 5px;
            font-size: medium;
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
                <th class="text-center">Tipo</th>
                {{-- <th class="text-center">Quantidade</th> --}}
                <th class="text-right">Receita</th>
                <th class="text-right">Despesa</th>
                <th class="text-right">Valor Total</th>
            </tr>

        </thead>
        <tbody>
            @forelse($report['categories'] as $category)
                <tr>
                    <td colspan="5">
                        Categoria : {{ $category['category_name'] }}
                    </td>
                </tr>
                <tr>
                    {{-- <td></td> --}}
                    <td>{{ $category['date_entry'] }}</td>
                    <td>{{ $category['description'] }}</td>
                    <td class="text-center">
                        @if ($category['type'] === 'income')
                            <span class="badge badge-success">{{ $category['total_formatted'] }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($category['type'] === 'expense')
                            <span class="badge badge-success">{{ $category['total_formatted'] }}</span>
                        @endif
                    </td>
                    {{-- <td class="text-center">{{ $category['count'] }}</td> --}}
                    <td class="text-right">
                        <strong class="{{ $category['type'] === 'income' ? 'text-success' : 'text-danger' }}">
                            {{ $category['total_formatted'] }}
                        </strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Nenhum lançamento encontrado no período
                    </td>
                </tr>
            @endforelse
        </tbody>
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

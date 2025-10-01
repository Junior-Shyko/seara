<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Financeiro - Setembro 2023</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        .container {
            background-color: white;
            border: 2px solid black;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .header p {
            font-size: 14px;
            margin: 3px 0;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0 10px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .header-row {
            background-color: #ffff00;
            font-weight: bold;
        }
        
        .total-row {
            background-color: #90ee90;
            font-weight: bold;
        }
        
        .resumo-header {
            background-color: #ffff00;
            font-weight: bold;
        }
        
        .sub-total-row {
            background-color: #90ee90;
            font-weight: bold;
        }
        
        td, th {
            border: 1px solid black;
            padding: 4px 8px;
            font-size: 12px;
        }
        
        .col-descricao {
            text-align: left;
            width: 70%;
        }
        
        .col-moeda {
            text-align: center;
            width: 10%;
            font-weight: bold;
        }
        
        .col-valor {
            text-align: right;
            width: 20%;
        }
        
        .receitas {
            border: 2px solid black;
        }
        
        .despesas {
            border: 2px solid black;
        }
        
        .resumo {
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>IGREJA ASSEMBLEIA DE DEUS</h1>
            <p>Rua do Paraíso, 556, Planalto Ayrton Senna</p>
            <p>CEP: 60.766-280 - FORTALEZA - CE</p>
            <p>CNPJ: 06.162.853/0001-55</p>
        </div>
        
        <div class="section-title">RELATÓRIO FINANCEIRO</div>
        <div class="section-title">SETEMBRO DE 2023</div>
        
        <!-- RECEITAS -->
        <div class="section-title">RECEITAS</div>
        <table class="receitas">
            <tr class="header-row">
                <td class="col-descricao">HISTÓRICO</td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">VALOR</td>
            </tr>
            @php
                $receipt = 0;
            @endphp
            @foreach ($accountLaunchReceipt as $item)
                <tr>
                    <td class="col-descricao">{{$item->entries_description}} - {{$item->account_types_name}}</td>
                    <td class="col-moeda">R$</td>
                    <td class="col-valor">{{number_format($item->entries_value,2,",",".")}}</td>
                </tr>
                @php
                $receipt += $item->entries_value;
                @endphp
            @endforeach
            <tr class="total-row">
                <td class="col-descricao">TOTAL DAS RECEITA >>>></td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">{{number_format($receipt,2,",",".")}}</td>
            </tr>
        </table>
        
        <!-- DESPESAS -->
        <div class="section-title">DESPESAS</div>
        <table class="despesas">
            <tr class="header-row">
                <td class="col-descricao">HISTÓRICO</td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">VALOR</td>
            </tr>
           @php
            $expense = 0;
            @endphp
            @foreach ($accountLaunchExpense as $item)
                <tr>
                    <td class="col-descricao">{{$item->entries_description}}</td>
                    <td class="col-moeda">R$</td>
                    <td class="col-valor">{{number_format($item->entries_value,2,",",".")}}</td>
                </tr>
                @php
                $expense += $item->entries_value;
                @endphp
            @endforeach
            <tr class="total-row">
                <td class="col-descricao">TOTAL DAS DESPESA >>>></td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">{{number_format($expense,2,",",".")}}</td>
            </tr>
        </table>
        
        <!-- RESUMO GERAL -->
        <div class="section-title">RESUMO GERAL</div>
        <table class="resumo">
            <tr class="resumo-header">
                <td class="col-descricao">HISTÓRICO</td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">VALOR</td>
            </tr>
            <tr>
                <td class="col-descricao">SALDO ANTERIOR</td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">{{number_format($previousBalance,2,",",".")}}</td>
            </tr>
            <tr>
                <td class="col-descricao">TOTAL DE RECEITAS</td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">{{number_format($receipt,2,",",".")}}</td>
            </tr>
            <tr class="sub-total-row">
                <td class="col-descricao">SUB-TOTAL</td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">
                    @php
                    $tot = ($previousBalance + $receipt);
                    echo number_format($tot,2,",",".");
                    @endphp

                </td>
            </tr>
            <tr>
                <td class="col-descricao">TOTAL DAS DESPESAS >>>></td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">{{number_format($expense,2,",",".")}}</td>
            </tr>
            <tr>
                <td class="col-descricao"><strong>SALDO FINAL</strong></td>
                <td class="col-moeda">R$</td>
                <td class="col-valor">
                    @php
                    $finalBalance = ($tot - $expense);
                    echo number_format($finalBalance,2,",",".");
                    @endphp
                </td>
            </tr>
        </table>
        <div class="section-title">LOCALIZAÇÃO DO SALDO FINAL</div>
        <table class="resumo">
            <tr>
                <td class="col-descricao">SALDO EM BANCO</td>
                <td class="col-moeda"></td>
                <td class="col-valor">{{number_format($generalBalnaceBank,2,",",".")}}</td>
            </tr>

            <tr>
                <td class="col-descricao">SALDO NO CAIXA INTERNO</td>
                <td class="col-moeda"></td>
                <td class="col-valor">{{number_format($interInternal,2,",",".")}}</td>
            </tr>
            <tr>
                <td class="col-descricao">TOTAL EM SALDOS</td>
                <td class="col-moeda"></td>
                <td class="col-valor">{{number_format($balanceGeneral,2,",",".")}}</td>
            </tr>
        </table>
    </div>
</body>
</html>
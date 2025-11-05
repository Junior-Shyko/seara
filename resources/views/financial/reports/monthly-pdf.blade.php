@extends('layouts.report.layout')
@push('stylesheets')
    <style>
        @page {
            margin: 20mm;
        }
        
        
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #000;
        }
        
        .header {
            text-align: center;
            padding: 5px;
        }
        
        .header h1 {
            font-size: 14pt;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10pt;
            margin: 3px 0;
        }
        
        .title {
            text-align: center;
            margin: 20px 0;
        }
        
        .title h2 {
            font-size: 13pt;
            font-weight: bold;
            margin: 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            background-color: #f5f576;
            border: 1px solid #000;
            padding: 4px;
            font-weight: bold;
            font-size: 10pt;
        }
        
        table td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 10pt;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .section-title {
            background-color: #9fee9f;
            font-weight: bold;
            text-align: center;
            border: 1px solid #5f5e5e;
            padding: 3px;
            margin-bottom: 1px;
        }
        
        .total-row {
            background-color: #e6e6d9;
            font-weight: bold;
        }
        
        .footer-info {
            margin-top: 10px;
            font-size: 9pt;
            text-align: center;
        }
    </style>
@endpush
@section('main_container')
    <!-- Cabeçalho -->
    <div class="header">
        <h1>{{ strtoupper($company->company_name ?? 'SEARA CONTABILIDADE') }}</h1>
        <p>{{ $company->company_addr_street ?? 'Rua do Paraíso, 556, Planalto Ayrton Senna' }}</p>
        <p>CEP: {{ $company->company_addr_cep ?? '60.766-280' }} - {{ $company->company_addr_city ?? 'FORTALEZA' }} - {{ $company->company_addr_state ?? 'CE' }}</p>
        <p><strong>CNPJ: {{ $company->company_cnpj ?? '06.162.853/0001-55' }}</strong></p>
    </div>
    
    <!-- Título -->
    <div class="title">
        <h2>RELATÓRIO FINANCEIRO</h2>
        <h2>{{ $report['period']['formatted'] }}</h2>
    </div>
    
    <!-- RECEITAS -->
    <div class="section-title">RECEITAS</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">HISTÓRICO</th>
                <th style="width: 10%;" class="text-center">R$</th>
                <th style="width: 20%;" class="text-right">VALOR</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report['receitas'] as $receita)
            <tr>
                <td>{{ strtoupper($receita['historico']) }}</td>
                <td class="text-center">R$</td>
                <td class="text-right">{{ $receita['total_formatted'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Nenhuma receita no período</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td><strong>TOTAL DAS RECEITAS >>>></strong></td>
                <td class="text-center"><strong>R$</strong></td>
                <td class="text-right"><strong>{{ $report['totals']['receitas_formatted'] }}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <!-- DESPESAS -->
    <div class="section-title">DESPESAS</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">HISTÓRICO</th>
                <th style="width: 10%;" class="text-center">R$</th>
                <th style="width: 20%;" class="text-right">VALOR</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report['despesas'] as $despesa)
            <tr>
                <td>{{ strtoupper($despesa['historico']) }}</td>
                <td class="text-center">R$</td>
                <td class="text-right">{{ $despesa['total_formatted'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Nenhuma despesa no período</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td><strong>TOTAL DAS DESPESAS >>>></strong></td>
                <td class="text-center"><strong>R$</strong></td>
                <td class="text-right"><strong>{{ $report['totals']['despesas_formatted'] }}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <!-- RESUMO GERAL -->
    <div class="section-title">RESUMO GERAL</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">HISTÓRICO</th>
                <th style="width: 10%;" class="text-center">R$</th>
                <th style="width: 20%;" class="text-right">VALOR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SALDO ANTERIOR</td>
                <td class="text-center">R$</td>
                <td class="text-right">{{ number_format($report['previous_balance'], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>TOTAL DE RECEITAS</td>
                <td class="text-center">R$</td>
                <td class="text-right">{{ $report['totals']['receitas_formatted'] }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>SUB-TOTAL</strong></td>
                <td class="text-center"><strong>R$</strong></td>
                <td class="text-right"><strong>{{ number_format($report['previous_balance'] + $report['totals']['receitas'], 2, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>TOTAL DAS DESPESAS</td>
                <td class="text-center">R$</td>
                <td class="text-right">{{ $report['totals']['despesas_formatted'] }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>SALDO FINAL</strong></td>
                <td class="text-center"><strong>R$</strong></td>
                <td class="text-right"><strong>{{ $report['totals']['saldo_final_formatted'] }}</strong></td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th class="section-title" colspan="3">LOCALIZAÇÃO DO SALDO FINAL</th>               
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 70%;">SALDO EM BANCO</td>
                <td style="width: 10%;" class="text-center">R$</td>
                <td style="width: 20%;" class="text-right">{{ number_format($totalBanks, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="width: 70%;">SALDO NO CAIXA INTERNO</td>
                <td style="width: 10%;" class="text-center">R$</td>
                <td style="width: 20%;" class="text-right">{{ number_format($totalCash, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="width: 70%;"><strong>TOTAL DOS SALDOS</strong></td>
                <td style="width: 10%;" class="text-center">R$</td>
                <td style="width: 20%;" class="text-right">{{ number_format($totalGeneral, 2, ',', '.') }}</td>
            </tr>
        </tbody>

    </table>
    <!-- Rodapé -->
    <div class="footer-info">
        <p>Relatório gerado em {{ now()->format('d/m/Y H:i') }}</p>
    </div>
@endsection
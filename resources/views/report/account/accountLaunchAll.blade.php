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
                    Empresa: {{$accountLaunchAll[0]['company_name']}} <br>
                    CNPJ: {{$accountLaunchAll[0]['company_cnpj']}}
                </small>
            </div>
            <div class="col-right"></div>
        </header>
        <header>
            <div class="col">Período: {{$dtInitReport}} a {{$dtEndReport}}</div>
            <div class="col-right">Seara Contabilidade</div>
        </header>

    </section>
    <br>
    <table style="width: 100%;" border="1" cellpadding="1">
        <tbody>
            <tr>
                <td>
                    <label>Data</label>
                </td>
                <td>Descrição</td>
                <td>Cédito</td>
                <td>Débito</td>
                <td>Saldo</td>
            </tr>
            <tr class=" bg-balance">
                <td colspan="3" class="bg-balance">
                    Saldo Anterior (Geral) :
                </td>
                <td colspan="2" class="bg-balance" style="border: 0px;background: #f3f3f3;">
                    <strong >R$: {{number_format($balance, 2, ',', '.')}}</strong>

                </td>
            </tr>
            @php
                $balance = 0;
                $previousBalance = 0;
                $balancePartial = 0;
                $accountPartial = 0;
                $indiceEncontrado = 'false';
            @endphp
            @foreach ($accountGroup as $valueGroup)

                <tr>
                    <td colspan="5" style="padding: 5px">
                        <strong><label>Conta: {{ $valueGroup->accountlaunch_name }}</label></strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <span> Saldo Anterior: R$ <strong>
                        @php
                            $balancePrevious =  \Seara\Repository\AccountLaunchRepository::getValueAccountLaunchEntry(
                                 $valueGroup->entries_id_company,
                                 $dtinit,
                                 $valueGroup->idAccountLaunch
                             );
                            echo number_format($balancePrevious, 2, ',', '.');
                        @endphp
                            </strong>
                        </span>
                    </td>
                </tr>
                @php $accountPartial = $valueGroup->id; @endphp
                @foreach ($accountLaunchAll as $key => $valAccount)
                    <tr>
                        {{-- {{$valAccount->id}} - {{$valueGroup->id}} --}}
                        @if ($valueGroup->id == $valAccount->id)
                            {{-- {{$valAccount->entries_description}} --}}
                            <td>
                                <small class="ml-5 td-launch">

                                    {{date('d/m/Y', strtotime($valAccount->entriesCreatedAt))}}
                                </small>
                            </td>
                            <td >
                                <small class="ml-5 td-launch">
                                    {{ $valAccount->entries_description }}
                                </small>

                            </td>

                            <td class="tr-center">
                                <small class="ml-5 td-launch">
                                    @if($valAccount->account_types_name == 'Receita')
                                        {{number_format($valAccount->entries_value,2,",",".")}}
                                        @php
                                        $balance = ($balance + $previousBalance + $valAccount->entries_value)
                                        @endphp
                                    @endif
                                </small>
                            </td>
                            <td class="tr-center">
                                <small class="ml-5 td-launch">
                                    @if($valAccount->account_types_name == 'Despesa')
                                        {{number_format($valAccount->entries_value,2,",",".")}}
                                        @php
                                        $balance = ($balance + $previousBalance - $valAccount->entries_value)
                                        @endphp
                                    @endif
                                </small>
                            </td>
                            <td class="tr-center">
                                <small class="ml-5 td-launch">
                                    {{number_format($balance,2,",",".")}}
                                </small>

{{--                                {{$balance }} - {{$accountPartial}} - {{$key}}--}}
                            </td>
                      @php  $indiceEncontrado = 'true';@endphp
                        @endif


                    </tr>
                @endforeach

                <tr>
                    <td colspan="3" style="padding: 5px; font-size: small;" class="bg-tot">

                            <label>
                                Totais do período
                                    <span class="smallPeriod">(s.ant + ent + sai + banco)</span>
                            </label>
                    </td>
                    <td class="bg-tot" colspan="2">
                        <label class="float-r ">
                            @php $sum = 0;
                            $sum = ($balancePrevious + $balance);
                            @endphp
                            R$: {{number_format($sum,2,",",".")}}
                        </label>
                    </td>
                </tr>
                @if($indiceEncontrado == 'true')
                @php  $balance = 0; @endphp
                @endif
                @php  $indiceEncontrado = 'false';  @endphp
            @endforeach
{{--            <tr class="bg-balance">--}}

{{--                <td colspan="3" style="padding: 5px; font-size: small;">--}}

{{--                        <label>--}}
{{--                            Resumo--}}
{{--                                <span class="smallPeriod">(s.ant + ent + sai)</span>--}}
{{--                        </label>--}}
{{--                </td>--}}
{{--                <td colspan="2">--}}
{{--                    <label class="float-r " >--}}
{{--                        <strong>R$: {{number_format($balance,2,",",".")}}</strong>--}}
{{--                    </label>--}}
{{--                </td>--}}
{{--            </tr>--}}
        </tbody>
    </table>
    <!-- DivTable.com -->
</body>

</html>

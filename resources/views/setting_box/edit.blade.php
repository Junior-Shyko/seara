@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="{{ asset('css/setting-box.css') }}" rel="stylesheet">
@endpush
@section('main_container')
    <div class="right_col" role="main" style="min-height: 948px;">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Editar de caixa</h3>
                </div>
                <div class="title_right">

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Caixa</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li>
                                    <a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Data da abertura:</th>
                                                <td>{{ \Carbon\Carbon::parse($setBox->date_open)->format('d/m/Y H:i:d') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Aberto por:</th>
                                                <td>{{ $setBox->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Data do fechamento:</th>
                                                @if ($setBox->date_close !== null)
                                                    <td>{{ \Carbon\Carbon::parse($setBox->date_close)->format('d/m/Y H:i:d') }}
                                                    </td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th>Fechado por:</th>
                                                <td>{{ $setBox->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Situação:</th>
                                                <td>
                                                    <label class="badge badge-primary">
                                                        {{ $setBox->slug == 'open' ? 'Aberto' : 'Fechado' }}
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mês de Referência:</th>
                                                <td>{{ \Carbon\Carbon::parse($setBox->date_open)->month }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <a href="{{ url('caixa') }}" class="btn btn-default pull-left"
                                            title="Voltar para caixas em geral">
                                            <i class="fa fa-arrow-circle-left"></i> Voltar
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('caixa') }}" class="btn btn-primary pull-right"
                                            title="Página de lançamento">
                                            <i class="fa fa-check-circle"></i> Ir para lançamento
                                        </a>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    @include('msg.message')

                                </div>

                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" class="btn btn-primary" data-toggle="collapse"
                                                    data-parent="#accordion" href="#collapseOne" aria-expanded="false"
                                                    aria-controls="collapseOne">
                                                    Fechar automaticamente
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                            aria-labelledby="headingOne">
                                            <div class="panel-body" style="display: flex; justify-content: center">
                                                <div class="col-md-12 text-center">
                                                    Ao confirmar o fechamento do caixa, você finaliza o caixa com a data de
                                                    hoje.
                                                    <p class="text-danger text-center">
                                                        <strong>Lembrando que ainda tem a possibilidade de reabrir o caixa,
                                                            caso deseje.</strong>
                                                    </p>
                                                    <p>
                                                        <button class="btn btn-danger"
                                                            onClick="updateSettingBox({{ $setBox->id }}, 'auto')"
                                                            id="btn-close-box-auto">
                                                            Confirmo fechamento do caixa
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a class="collapsed btn btn-default" role="button" data-toggle="collapse"
                                                    data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    Fechar com edição de data
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                            aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                                <p class="text-center">
                                                    Essa opção, possibilita de fazer alteração da data do tempo/espaço do caixa.
                                                </p>
                                                <form id="form-edit-box" data-parsley-validate="" method="POST"
                                                    action="{{ url('caixa') }}" class="form-horizontal form-label-left"
                                                    novalidate="">
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="first-name">Data de início
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input id="date_open_box" class="form-control"
                                                                placeholder="dd/mm/aaaa" type="text" required="required"
                                                                name="date_open"
                                                                value="{{ \Carbon\Carbon::parse($setBox->date_open)->format('d/m/Y H:i:d') }}">
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="last-name">Data final
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input id="date_close_box_edit"
                                                                class="date-picker form-control" placeholder="dd/mm/aaaa"
                                                                type="text" name="date_close">
                                                            <p class="text-muted" style="color: darkgoldenrod;">Para
                                                                fechar o caixa, basta
                                                                preencher a data do fechamento.</p>
                                                        </div>
                                                    </div>

                                                    <div class="ln_solid"></div>
                                                    <div class="item form-group">

                                                        <div class="col-md-6">

                                                        </div>
                                                        <div class="col-md-6 col-sm-6 offset-md-3">
                                                            <input type="hidden" name="id_user_open"
                                                                value="{{ Auth::user()->id }}">
                                                            <button type="button"
                                                                onClick="updateSettingBox({{ $setBox->id }} , 'form')"
                                                                class="btn btn-danger pull-right"
                                                                title="Altera e/ou fecha o caixa">
                                                                <i class="fa fa-money"></i> Fechar Caixa
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="ln_solid"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <br>
                            <div class="clearfix"></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" language="javascript" src="{{ asset('js/setting_box/setting-box.js') }}"></script>
@endpush

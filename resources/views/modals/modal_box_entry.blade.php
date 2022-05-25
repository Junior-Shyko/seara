<link href="{{ url('css/entry.min.css') }}" rel="stylesheet">
<style>
    .dropzone .dz-message {
        text-align: center;
        margin: 2em 0;
        font-size: 20px !important;
        color: #4e65dc !important;
        background: #e5e5ea !important;
        padding: 10px !important;
        border-radius: 8px !important;
    }

    .container {
        margin-top: 20px;
    }

</style>
<div class="modal fade bs-example-modal-lg" id="lancar_conta" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Lançamento no Caixa</h4>
            </div>
            <div class="modal-body">
                <div class="row alert alert-info" id="infoMonthLaunch">
                    <div class="col-md-6">
                        <p id="monthYear">
                            <strong>MÊS / ANO:
                            </strong>{{ \Carbon\Carbon::now()->month . ' / ' . \Carbon\Carbon::now()->year }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="pull-right">
                            <strong>
                                Saldo Atual: {{ number_format($saldo, 2, ',', '.') }}
                            </strong>
                        </h4>
                    </div>
                </div>
                {{-- @include('entry.form') --}}
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                data-toggle="tab">Lançamento</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                data-toggle="tab">Transferência</a></li>
                        {{-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                      <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> --}}
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            @include('entry.form')
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4>Suas contas bancárias</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <small class="text-danger">Conta de saída</small>
                                        <select name="" id="" class="form-control">
                                            <option value="0">--Selecione--</option>
                                            @foreach ($accountBank as $bank)
                                                <option value="{{ $bank->id }}">
                                                    {{ $bank->nameBank }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Valor para transferência</small>
                                        <input type="text" name="" id="" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <label>informações</label>
                                        <p>Saldo: R$ 987,00 - Tipo: Poupança - N. Conta: 76543-09</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <small class="text-danger">Conta de entrada</small>
                                        <select name="" id="" class="form-control">
                                            <option value="0">--Selecione--</option>
                                            @foreach ($accountBank as $bank)
                                                <option value="{{ $bank->id }}">
                                                    {{ $bank->nameBank }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Valor para transferência</small>
                                        <input type="text" name="" id="" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <label>informações</label>
                                        <p>Saldo: R$ 0,70 - Tipo: Poupança - N. Conta: 6Y7U-XX</p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-bottom: 5px;"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default  pull-left"
                                    data-dismiss="modal">Sair</button>
                                <a id="btnTransferValue" class="btn btn-primary">
                                    <i class="fa fa-exchange" aria-hidden="true"></i> Transferir
                                </a>
                            </div>
                        </div>
                        {{-- <div role="tabpanel" class="tab-pane" id="messages">...</div>
                      <div role="tabpanel" class="tab-pane" id="settings">...</div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

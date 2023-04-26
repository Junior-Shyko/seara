<link href="{{ url('css/entry.min.css') }}" rel="stylesheet">
<div class="modal fade bs-example-modal-lg" id="lancar_conta" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Lançamento no Caixa</h4>
            </div>
            <div class="modal-body">
                <div class="row alert space-money" id="infoMonthLaunch">
                    
                    <div class="col-xs-12 col-sm-12 col-md-3 info-money-box badge bg-green">
                        <h5 class="">
                            <strong>
                                Saldo banco: <br>
                            </strong>
                        </h5>
                        <span id="balance_bank"> 0</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 info-money-box badge badge-dark">
                        <h5 class="">
                            <strong>
                                Caixa Interno:
                            </strong>
                        </h5>
                        <span id="balance_c_internal"> 0</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 info-money-box badge badge-blue">
                        <h5 class="">
                            <strong>
                                Caixa Geral:
                            </strong>
                        </h5>
                        <span id="balance_box_general"> 0</span>
                    </div>
                </div>
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="tabs-form-launch" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#bank" aria-controls="bank" role="tab"
                            data-toggle="tab">Bancos</a>
                        </li>
                        <li role="presentation"><a href="#home" aria-controls="home" role="tab"
                                data-toggle="tab">Caixa interno</a></li>
                               
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                data-toggle="tab">Transferência</a></li>
                        {{-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                      <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> --}}
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="bank">
                            <form class="form-horizontal form-label-left input_mask" id="form_entry_bank">
                                @component('components.form-entry', [
                                    'accounts' => $accounts,
                                    'idCompany' => $idCompany,
                                    'badge_title' => 'bg-green',
                                    'saveBtnForm' => 'form_entry_bank'
                                    ])
                                    @slot('title', 'Caixa Bancário')
                                    @slot('option_bank')
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="">Selecione um banco</label>                                       
                                                <select name="entries_bank" id="select-form-option-bank" class="form-control">
                                                    <option value="--">-- --</option>
                                                    @foreach ($accountBank as $bank)
                                                        <option value="{{ $bank->bank_id }}">
                                                            {{ $bank->nameBank }}
                                                        </option>
                                                    @endforeach
                                                </select>                                           
                                            </div>
                                        </div>
                                    </div>
                                    @endslot
                                @endcomponent
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane " id="home">
                            <form class="form-horizontal form-label-left input_mask" id="form_entry_internal">
                            
                            @component('components.form-entry', [
                                'accounts' => $accounts,
                                'idCompany' => $idCompany,
                                'badge_title' => 'badge-dark',
                                'saveBtnForm' => 'form_entry_internal'
                                ])
                                @slot('title', 'Caixa Interno')
                                @slot('option_bank', '')
                            @endcomponent
                            </form>
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
                                        <select name="" id="selectAccountBankEnd" class="form-control">
                                            <option value="">--Selecione--</option>
                                            <option value="0">CAIXA INTERNO</option>
                                            @foreach ($accountBank as $bank)
                                                <option value="{{ $bank->id }}">
                                                    {{ $bank->nameBank }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Valor para transferência</small>
                                        <input type="text" name="realValueTranfer" id="realValueTranfer" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <label>informações</label>
                                        <p>Saldo: <small id="balanceEndAccount">0.00</small> - Tipo: <small id="infoTypeAccountBank"></small> - N. Conta: 76543-09</p>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <small class="text-danger">Conta de entrada</small>
                                        <select name="" id="selectAccountBankEntry" class="form-control">
                                            <option value="">--Selecione--</option>
                                            <option value="0    ">Caixa Interno</option>
                                            @foreach ($accountBank as $bank)
                                                <option value="{{ $bank->id }}">
                                                    {{ $bank->nameBank }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        {{-- 
                                        <small>Valor para transferência</small>
                                        <input type="text" name="" id="" class="form-control"> --}}
                                    </div>
                                    <div class="col-md-5">
                                        <label>informações</label>
                                        <p>Saldo: <small id="balanceEntryAccount">0.00</small>  - Tipo: Poupança - N. Conta: 6Y7U-XX</p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="padding-bottom: 10px"></div>
                            <div class="modal-footer">
                                <input type="hidden" name="valueGetInfo" id="valueGetInfo">
                                <input type="hidden" name="valueInternal" id="valueInternal" value="{{ number_format($saldo, 2, ',', '.') }}">
                                <input type="hidden" name="transaction_id" id="transaction_id_transfer" value="2">
                                <button type="button" class="btn btn-default  pull-left"
                                    data-dismiss="modal">Sair</button>
                                    <a id="btnTransferValue" onclick="transferValue()" class="btn btn-primary">
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

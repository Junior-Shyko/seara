<link href="{{ url("css/entry.min.css") }}" rel="stylesheet">
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
    .container{
    margin-top:20px;
    }
    .image-preview-input {
    position: relative;
    overflow: hidden;
    margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
    }
    .image-preview-input input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
    }
    .image-preview-input-title {
    margin-left:2px;
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
                            <strong>MÊS / ANO: </strong>{{ \Carbon\Carbon::now()->month . ' / '. \Carbon\Carbon::now()->year }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="pull-right">Saldo Atual: {{number_format($saldo,2,",",".")}}</h4>
                    </div>
                </div>
                @include('entry.form')
            </div>
        </div>
    </div>
</div>
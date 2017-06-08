@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush
@section('main_container')
<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Caixa <small>Registrar Caixa</small></h2>
                    <a class="btn btn-app pull-right" data-toggle="modal" data-target="#create_account">
                    <i class="fa fa-list-ol" aria-hidden="true"></i> Criar Conta
                    </a>
                    @include('modals.modal_account')
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                    <a href="#lancar_conta" data-toggle="modal"><button class="btn btn-primary pull-right"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Lançar registro</button></a>
                </div>
                <div class="x_content">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 191px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 311px;">Position</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 144px;">Office</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 77px;">Age</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 142px;">Start date</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 112px;">Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Airi Satou</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>33</td>
                                            <td>2008/11/28</td>
                                            <td>$162,700</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Angelica Ramos</td>
                                            <td>Chief Executive Officer (CEO)</td>
                                            <td>London</td>
                                            <td>47</td>
                                            <td>2009/10/09</td>
                                            <td>$1,200,000</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>66</td>
                                            <td>2009/01/12</td>
                                            <td>$86,000</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Bradley Greer</td>
                                            <td>Software Engineer</td>
                                            <td>London</td>
                                            <td>41</td>
                                            <td>2012/10/13</td>
                                            <td>$132,000</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Brenden Wagner</td>
                                            <td>Software Engineer</td>
                                            <td>San Francisco</td>
                                            <td>28</td>
                                            <td>2011/06/07</td>
                                            <td>$206,850</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Brielle Williamson</td>
                                            <td>Integration Specialist</td>
                                            <td>New York</td>
                                            <td>61</td>
                                            <td>2012/12/02</td>
                                            <td>$372,000</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Bruno Nash</td>
                                            <td>Software Engineer</td>
                                            <td>London</td>
                                            <td>38</td>
                                            <td>2011/05/03</td>
                                            <td>$163,500</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Caesar Vance</td>
                                            <td>Pre-Sales Support</td>
                                            <td>New York</td>
                                            <td>21</td>
                                            <td>2011/12/12</td>
                                            <td>$106,450</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Cara Stevens</td>
                                            <td>Sales Assistant</td>
                                            <td>New York</td>
                                            <td>46</td>
                                            <td>2011/12/06</td>
                                            <td>$145,600</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>22</td>
                                            <td>2012/03/29</td>
                                            <td>$433,060</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-example-modal-lg" id="lancar_conta" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">lancar caixa</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row alert alert-info">
                                        <p>
                                            <strong>MÊS / ANO: </strong>{{ \Carbon\Carbon::now()->month . ' / '. \Carbon\Carbon::now()->year }}
                                            <label class="pull-right">Saldo Anterior: R$ {{'0,00'}}</label>
                                        </p>
                                        
                                    </div>
                                    <form class="form-horizontal form-label-left input_mask">

                                      <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Dia">
                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                                      </div>

                                      <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Histórico">
                                        <span class="fa fa-edit form-control-feedback right" aria-hidden="true"></span>
                                      </div>
                                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                          <small>ENTRADAS</small>
                                      </div>  
                                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" name="boxes_decimate"  class="form-control has-feedback-left" id="boxes_decimate" placeholder="Dízimo">
                                        <span class="fa fa-money form-control-feedback left" id="" aria-hidden="true"></span>
                                      </div>
                                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" name="box_offer" class="form-control has-feedback-left" id="box_offer" placeholder="Oferta">
                                        <span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Outras">
                                        <span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                   <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                          <small>SAÍDA</small>
                                      </div> 
                                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control" id="inputSuccess5" placeholder="Saída">
                                        <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                                      </div>
                
                                      <div class="ln_solid"></div>
                                        <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                          <h4 class="pull-right form-label">SALDO: R$ </h4>
                                      </div>  

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

{{Html::script('js/box.js')}}
{{Html::script('js/mask.min.js')}}


<script type="text/javascript">
$('#boxes_decimate').mask('000.000.000.000.000,00', {reverse: true});
$('#box_offer').mask('000.000.000.000.000,00', {reverse: true});

   $(function() {
       $("#save_account").click(function(event) {
            /* Act on the event */
            route = '{{url('conta')}}';
            name_account    = $("#accounts_name").val();
            id_type_account = $("#accounts_id_type_account").val(); 
            id_user         = '{{Auth::user()->id}}';
            id_company      = '{{Auth::user()->user_id_company}}';
            $.ajax({
                url: route,
                type: 'POST',
                 data: {accounts_name: name_account , accounts_id_user: id_user, accounts_id_company: id_company, accounts_id_type_account: id_type_account },
                
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function(){
                    new PNotify({
                      title: 'Cadastrado',
                      text: 'Conta Registrada com sucesso',
                      type: 'success',
                      styling: 'bootstrap3'
                    });
                    $('#accounts_name').val('');
                }
               
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            


        });
   });
</script>

@endpush


<!-- /page content -->
@endsection

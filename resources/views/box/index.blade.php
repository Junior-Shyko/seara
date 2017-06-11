@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
{{Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css')}}
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
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 112px;">Ação</th>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
                @include('modals.modal_box_entry');
            </div>
        </div>
    </div>
</div>
@push('scripts')
{{Html::script('js/box.js')}}
{{Html::script('js/mask.min.js')}}
{{Html::script('plugins/bootstrap-daterangepicker/moment.min.js')}}
{{Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js')}}
{{Html::script('plugins/form-serializer/jquery.serialize-object.js')}}

<script type="text/javascript">
        $('#boxes_decimate').mask('000.000.000.000.000,00', {reverse: true});
        $('#box_offer').mask('000.000.000.000.000,00', {reverse: true});
        $('#box_other').mask('000.000.000.000.000,00', {reverse: true});
        $('#box_exit').mask('000.000.000.000.000,00', {reverse: true});
    
       $(function() {
        var route = '{{url('conta')}}';
           $("#save_account").click(function(event) {
                /* Act on the event */
                
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


            $("#cod_account").blur(function(event) {
               /* Act on the event */
                code_account = $("#cod_account").val();
                route_get_account = '{{url('conta')}}';
                $.get( route_get_account+'/'+code_account, function( data ) {
                  $( "#label_desc_account" ).html( data[0][0].accounts_name);
                  nome_tipo_conta = data[0][0].type_accounts_name.toUpperCase();
                  $( "#label_desc_type" ).html( "Tipo de conta: " + nome_tipo_conta);
                  
                  $( "#description_account" ).val( data[0][0].accounts_name);                  
                });
               
            });

            //SUBMIT DO FORM
            $("#save_entry").click(function(){
                console.log($('form#form_entry').serializeObject());
            });
       });
</script>
@endpush
<!-- /page content -->
@endsection

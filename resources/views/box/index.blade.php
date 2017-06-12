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
                                <table id="table_launch" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Dia</th>
                                            <th>Descrição</th>
                                           {{--  <th>Oferta</th>
                                            <th>Outros</th>
                                            <th>Saída</th>
                                            <th>Ação</th> --}}
                                        </tr>
                                    </thead>
                                    
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
{{-- {{Html::script('plugins/datatables.net/css/jquery.dataTables.css')}} --}}
{{Html::script('plugins/datatables.net/js/jquery.dataTables.js')}}
{{Html::script('plugins/form-serializer/jquery.serialize-object.js')}}

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_launch').DataTable({
            
            serverSide: true,
            ajax: '{{url('caixa/show')}}',
            columns: [  
                { data: 'boxes_day', name: 'boxes_day' },
                { data: 'boxes_description', name: 'boxes_description' }]
            }); 
    }); 
</script>


<script type="text/javascript">
        $('#boxes_decimate').mask('000.000.000.000.000,00', {reverse: true});
        $('#box_offer').mask('000.000.000.000.000,00', {reverse: true});
        $('#box_other').mask('000.000.000.000.000,00', {reverse: true});
        $('#box_exit').mask('000.000.000.000.000,00', {reverse: true});
    
       $(function() {
        var route       = '{{url('conta')}}';
        var route_box   = '{{url('caixa')}}';
        var token       =  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
           $("#save_account").click(function(event) {
                /* Act on the event */
                
                name_account    = $("#accounts_name").val();
                id_type_account = $("#accounts_id_type_account").val(); 
                id_user         = '{{Auth::user()->id}}';
                id_company      = '{{Auth::user()->user_id_company}}';
                console.log(id_type_account);
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
                console.log();
                $.ajax({
                    url: route_box,
                    type: 'POST',
                    dataType: 'json',
                    headers: token,
                    data: $('form#form_entry').serializeObject(),
                    success:function(){
                        new PNotify({
                          title: 'Cadastrado',
                          text: 'Seu lançamento foi realizado com sucesso',
                          type: 'success',
                          styling: 'bootstrap3'
                        });
                        $('form#form_entry')[0].reset();
                        $("#cod_account").focus();
                    }
                })
                .done(function() {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                    new PNotify({
                          title: 'Erro',
                          text: 'Ocorreu um erro, tente novamente',
                          type: 'danger',
                          styling: 'bootstrap3'
                        });
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

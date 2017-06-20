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
                    @if(count($box) == 0)
                    <a href="#modal_open_box" data-toggle="modal"><button class="btn btn-success pull-left"> <i class="fa fa-money" aria-hidden="true"></i> Abrir o primeiro caixa</button></a>
                    @endif
                    @include('modals.modal_open_box')
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
                                            <th>Dízimo</th>
                                            <th>Oferta</th>
                                            <th>Outros</th>
                                            <th>Saída</th>
                                            <th>Ação</th>
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
                @include('modals.modal_delete_launch');
            </div>
        </div>
    </div>
</div>
@push('scripts')
{{Html::script('js/box.js')}}
{{Html::script('js/mask.min.js')}}
{{Html::script('plugins/datatables.net/css/jquery.dataTables.css')}}
{{Html::script('plugins/datatables.net/js/jquery.dataTables.js')}}
{{Html::script('plugins/form-serializer/jquery.serialize-object.js')}}
<script type="text/javascript">
    $(document).ready(function() {
    
        $('#table_launch').DataTable({
            
        ajax: {
            url:  '{{url('caixa/show')}}',
            dataSrc: ''
    
        },
        columns: [  
            { data: 'entries_day', name: 'entries_day' },
            { data: 'entries_description', name: 'entries_description' },
            { data: 'entries_decimate', name: 'entries_decimate' },
            { data: 'entries_offer', name: 'entries_offer' },
            { data: 'entries_other', name: 'entries_other' },
            { data: 'entries_end', name: 'entries_end' },
            {
                 data: "entries_id",
                 bSortable: false,
                 mRender: function (data) { return '<a href="#" class="btn btn-info" ><i class="fa fa-pencil" style="font-size: 12px;" data-original-title="Alterar"></i></a> <a href="#" class="btn btn-danger" onclick="delete_launch('+data+')" ><i class="fa fa-trash" style="font-size: 12px;" title="Excluir"></i></a>'; }
             }
        ],
        language: {
          "lengthMenu": "Exibir _MENU_ recibos por página",
          "zeroRecords": "Nenhum recibo cadastrado para essa pesquisa",
          "infoEmpty": "Exibindo 0 de 0 recibos",
          "emptyTable": "Nenhum recibo cadastrado",
          "info": "Exibindo página _PAGE_ de _PAGES_",
          "infoFiltered": "(filtrados de _MAX_ recibos)",
          "search": "Pesquisar:",
          "paginate": {
            "previous": "Anterior",
            "next": "Próximo",
            "first": "Primeiro",
            "last": "Último"
          }
        },
        }); 
    }); 
    
    function reloadTable()
    {
      $("#table_launch").DataTable().ajax.reload();
    }
    
    function delete_launch(id){
    token_delete_launch  =  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
    $("#modal_delete_launch").modal('show');
        $("#btn-conf-delete-launch").click(function(){
            $.ajax({
                url: 'caixa/delete',
                type: 'POST',
                dataType: 'json',
               headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: {boxes_id: id},
                success:function(response){
                    reloadTable();
                    $("#modal_delete_launch").modal('hide');
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
    }
    
</script>
<script type="text/javascript">
    $('#boxes_decimate').mask('000.000.000.000.000,00', {reverse: true});
    $('#box_offer').mask('000.000.000.000.000,00', {reverse: true});
    $('#box_other').mask('000.000.000.000.000,00', {reverse: true});
    $('#box_exit').mask('000.000.000.000.000,00', {reverse: true});
    
    $(function() {
    var route       = '{{url('conta')}}';
    var route_box   = '{{url('caixa')}}';
    var token  =  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
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
              
              $( "#boxes_description" ).val( data[0][0].accounts_name);                  
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
                    reloadTable();
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

@extends('layouts.blank')

@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')
<div class="right_col" role="main" style="min-height: 948px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Permissão de Usuários</h3>
            </div>
            <div class="title_right">
                {{-- <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="table-responsive">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                    @include('msg.message')
                    <div class="x_title">
                        <h2>Lista com todos usuário e suas permissões</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                              <button type="button" class="btn btn-default" 
                              onclick="modalLogin({{Auth::user()->user_id_company}})"
                              title="Adiciona um novo usuário">
                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                criar usuário
                              </button>
                            </li>
                            <li>
                             <!-- Button trigger modal -->
                             <button class="btn btn-info" type="button" id="dropdownMenu1" 
                             data-toggle="modal" data-target="#modalInfoPermission">
                               <i class="fa fa-info-circle" aria-hidden="true"></i> Informação                              
                             </button>
                            </li>  
                            <li>
                              <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>                            
                            <li>
                              <a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                      <div class="x_content">
                        <div class="table-responsive">
                          <table class="table table-bordered" id="table_permission_user">
                            <thead>
                              <tr class="bg-primary">
                                <th>Usuário</th>
                                <th>Igreja</th>
                                <th>Nível</th>
                                <th>Ação</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de criar acesso-->
@include('modals.company.alterAccess',['roles' => $roles])

<!-- Modal -->
<div class="modal fade" id="modalInfoPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Níveis e permissões</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="list-group">
           
            <ul>
             @foreach ($allRoleSpatie as $item)
                
                 @role('superAdmin')
                 <li>{{$item->name}}</li>
                 @foreach ($item->getAllPermissions() as $getP)
                     <ul>
                     <li>{{$getP->name}}  </li>
                     </ul>
                 @endforeach
                  @else
                      @if ($item->name !== 'superAdmin')
                      <li>{{$item->name}}</li>
                        @foreach ($item->getAllPermissions() as $getP)
                            <ul>
                            <li>{{$getP->name}}  </li>
                            </ul>
                        @endforeach
                      @endif
                  @endrole
                
             @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalEditPermissionUser" tabindex="-1" role="dialog" aria-labelledby="modelEditPermissionUser">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Alterar Permissão</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                      Nível atual: <span class="badge" id="info-role-user">user</span>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
              {{Form::select(
                'select_role_users',
                $roles,
                null,
                [
                  'class' => 'form-control',
                  'id' => 'select_role_users',
                  'placeholder' => '--Selecione--'
                ])
              }}               
              <hr>
            </div>            
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="list-group">
                  <a href="#" class="list-group-item active">
                    Permissão atual: <span class="badge" id="info-permission-user">user</span>
                  </a>
              </div>
            </div>
            <div class="col-md-12">
              {{Form::select(
                'select_permission_users',
                $permission,
                null,
                [
                  'class' => 'form-control',
                  'id' => 'select_permission_users',
                  'placeholder' => '--Selecione--'
                ])
              }}
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="user_id" id="role_user_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        </div>
      </div>
    </div>
  </div>
  @include('modals.permission.modal_delete_permission')
@endsection

@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/permission/list_permission.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/customer.min.js') }}"></script>
@endpush

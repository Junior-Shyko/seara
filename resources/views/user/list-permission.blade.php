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
                        <h2>List com todos usuário e suas permissões</h2>
                        <ul class="nav navbar-right panel_toolbox">
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
                                <th>Permissão</th>
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
                      Nível atual: <span class="badge">user</span>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <select name="" id="" class="form-control">
                    <option value="">--Selecione--</option>
                    <option value="">Usuário Comum</option>
                </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL DE EXCLUIR PERMISSAO DE USUARIO -->
  <div class="modal fade" id="modalDeletePermissionUser" tabindex="-1" role="dialog" aria-labelledby="modalDeletePermissionUser">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="title-h4-modal">Excluir Permissão</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-danger" role="alert">
                <label for="" id="body-delete-user-permission">Deseja realmente excluir esse permissao </label>
              </div>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <input type="text" name="idDeleteUserPermission" id="idDeleteUserPermission">
          <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
          <button type="button" class="btn btn-danger" id="btn-delete-user-permission">Sim, excluir</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/permission/list_permission.min.js')}}"></script>
@endpush
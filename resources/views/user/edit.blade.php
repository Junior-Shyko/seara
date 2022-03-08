@extends('layouts.blank')

@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

<!-- page content -->
<div class="right_col" role="main">
  <div class="row">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">
          <div class="x_title">
            <h2>Editar<small> {{$subTitle}}</small></h2>

          </div>
        </h3>
      </div>
      <div class="panel-body">

       <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

         <div class="x_content">
         @include('msg.message')
          <br />

          {{Form::open(['url' => 'users/'.$user[0]->id, 'method' => 'PUT'], ['class' => 'form-horizontal form-label-left input_mask'])}}
          <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="name" value="{{$user[0]->name}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Nome completo">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="email" value="{{$user[0]->email}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="E-mail">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="password" name="password"  class="form-control has-feedback-left" id="inputSuccess3" placeholder="Senha">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_cpf" value="{{$user[0]->user_cpf}}" class="form-control has-feedback-left" id="inputSuccess3" placeholder="CPF">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="user_birth" name="user_birth" value="{{isset($user[0]->user_birth) ? $user[0]->user_birth : '' }}" 
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_phone" value="{{$user[0]->user_phone}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Telefone">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_cep" value="{{$user[0]->user_addr_cep}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="CEP">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>

              <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_street" value="{{$user[0]->user_addr_street}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Endereço">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_number" value="{{$user[0]->user_addr_number}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Número">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_complement" value="{{$user[0]->user_addr_complement}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Complemento">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_district" value="{{$user[0]->user_addr_district}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Bairro">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_city" value="{{$user[0]->user_addr_city}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Cidade">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="user_addr_state" value="{{$user[0]->user_addr_state}}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Estado">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
               {{-- <label class="control-label col-md-2 col-sm-3 col-xs-12">Gênero</label> <br> --}}
               <div class="btn-group" data-toggle="buttons">

                <label class="btn btn-primary  active ">
                  <input type="radio" name="user_sex" value="Masculino" id="option2" autocomplete="off"> Masculino
                </label>
                <label class="btn btn-primary ">
                  <input type="radio" name="user_sex" value="Feminino" id="option3" autocomplete="off"> Feminino
                </label>
              </div>
              <br>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <button type="submit" class="btn btn-success pull-right">Alterar Dados</button>
              </div>
            </div>

          </div>
          <div class="col-md-2"></div>
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
</div>
</div>

</div>
</div>
<!-- /page content -->
@endsection


@push('scripts')

  <script src="{{ asset("js/mask_camp.min.js") }}">

  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      initMask();
    });
  </script>

@endpush

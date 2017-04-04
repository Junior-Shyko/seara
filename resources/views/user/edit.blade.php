@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Editar<small>edite seus dados do perfil</small></h2>

                </div> 
                                 <div class="x_content">
                    <br />
                   <form class="form-horizontal form-label-left input_mask">

                      <div class="col-md-12">
                          <div class="col-md-2"></div>
                          <div class="col-md-8">
                              <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Nome completo">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="E-mail">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" class="form-control has-feedback-left" id="inputSuccess3" placeholder="Senha">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess3" placeholder="CPF">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Data nascimento">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>

                              
                              

                               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Telefone">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="CEP">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>

                                <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Endereço">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Número">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Complemento">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Bairro">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Cidade">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Estado">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                               <label class="control-label col-md-2 col-sm-3 col-xs-12">Gênero</label>
                                <div class="btn-group" data-toggle="buttons">
                             
                                  <label class="btn btn-primary  active ">
                                    <input type="radio" name="options" id="option2" autocomplete="off"> Masculino
                                  </label>
                                  <label class="btn btn-primary ">
                                    <input type="radio" name="options" id="option3" autocomplete="off"> Feminino
                                  </label>
                                </div>
                                <br>
                              </div>

                              <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12">
                         
                          <button class="btn btn-default" type="reset">Limpar</button>
                          <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                        </div>
                      </div>

                          </div>
                          <div class="col-md-2"></div>
                      </div>
                    </form>  
                  </div>   
            </div>
          </div>
        </div>      
    </div>
  <!-- /page content -->

    <!-- footer content -->
    <footer>
        <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

@endsection

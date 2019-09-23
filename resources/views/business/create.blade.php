@extends('layouts.blank')

@section('main_container')

<!-- page content -->
<div class="right_col" role="main">
  <div class="row">

    <!-- Alert para erros de cadastro -->
    <div id="signup-error" class="hidden login_wrapper alert alert-danger alert-dismissible fade in" style="max-width: 1000px;" role="alert">
      <button type="button" class="close" onclick="$('#signup-error').hide(); $('#signup-error-msg').text('')" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>Erro:</strong> <span id="signup-error-msg"></span>
    </div>

    <div class="login_wrapper" style="max-width: 1000px;">

      <div class="animate form login_form">
        <div id="wizard" class="form_wizard wizard_horizontal">
          <ul class="wizard_steps anchor">
            <li>
              <a href="#step-1" class="selected" isdone="1" rel="1">
                <span class="step_no">1</span>
                <span class="step_descr">
                  Passo 1<br>
                  <small>CNPJ da Empresa</small>
                </span>
              </a>
            </li>
            <li>
              <a href="#step-2" class="disabled" isdone="0" rel="2">
                <span class="step_no">2</span>
                <span class="step_descr">
                  Passo 2<br>
                  <small>Cadastro da Empresa</small>
                </span>
              </a>
            </li>
            <li>
              <a href="#step-3" class="disabled" isdone="0" rel="3">
                <span class="step_no">3</span>
                <span class="step_descr">
                  Passo 3<br>
                  <small>Cadastro do Responsável</small>
                </span>
              </a>
            </li>
          </ul>
          <!-- <div class="stepContainer" style="height: 282px;"> -->

          @include('register.step1')
          @include('register.step2')
          @include('register.step3')
          <!-- </div> -->
        </div>
      </div>
    </div>
    <!-- Gentelella -->
    @include('modals.signup_confirmation');
  </div>
</div>

@endsection

@push('scripts')
  <script>
    var base_url = "{{ url('') }}"
  </script>
  <script src="{{ asset("js/register.min.js") }}"></script>
@endpush
<!-- /page content -->



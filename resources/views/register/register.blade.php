@extends('layouts.layout_app')
@section('title', 'Page Title')
@section('content')
 @include('layouts.welcome_seara')
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
                <li>
                    <a href="#step-4" class="disabled" isdone="0" rel="4">
                    <span class="step_no">4</span>
                    <span class="step_descr">
                    Passo 4<br>
                    <small>Informações Adicionais</small>
                    </span>
                    </a>
                </li>
            </ul>
            <!-- <div class="stepContainer" style="height: 282px;"> -->
            @include('register.step1')
            @include('register.step2')
            @include('register.step3')
            @include('register.step4')
            <!-- </div> -->
        </div>
    </div>
</div>
<!-- Gentelella -->

@include('modals.signup_confirmation');
@endsection

@push('scripts')
  <script src="{{ asset("js/register.min.js") }}"></script>
@endpush

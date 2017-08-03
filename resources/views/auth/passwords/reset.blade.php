@extends('layouts.layout_app')
@section('title', 'Page Title')
@section('content')
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}"
                data-parsley-validate>
                    <h1>Redefinir Senha</h1>
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" required data-parsley-required-message="Campo Obrigatório"
                        class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password-reset" type="password" required data-parsley-required-message="Campo Obrigatório"
                        minlength="6" data-parsley-minlength-message="A senha deve conter no mínimo 6 caracteres."
                        class="form-control" name="password" placeholder="Senha"
                        value="{{ old('password') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input type="password" required data-parsley-required-message="Campo Obrigatório"
                        data-parsley-equalto="#password-reset" data-parsley-equalto-message="As senhas devem ser idênticas."
                        class="form-control" name="password_confirmation" placeholder="Confirmação de Senha"
                        value="{{ old('password_confirmation') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-default btn-block">
                              Redefinir minha senha
                            </button>
                        </div>
                    </div>
                    <div class="separator">
                        <p class="change_link">Já sabe sua senha?
                            <a href="{{ url('/login') }}" class="to_register"> Faça Log in </a>
                        </p>

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1>Produto Excellence Soft</h1>
                            <p>©2017 Todos os diretiros reservados a <a href="http://excellencesoft.com.br/" target="_blank" style="color: #E67716;">Excellence Soft</a></p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset("js/parsley.min.js") }}"></script>
@endpush

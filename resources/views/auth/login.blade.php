@extends('layouts.layout_app')
@section('title', 'Page Title')
@section('content')
<div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="post" action="{{ url('/login') }}">
                    {!! csrf_field() !!}

                    <h1>Login</h1>
                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" placeholder="Senha" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                        @endif

                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary submit" value="Acessar">
                        <a class="reset_pass" href="{{  url('/password/reset') }}">Esqueceu a Senha?</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Não tem conta?
                            <a href="{{ url('/cadastro') }}" class="to_register"> Criar meu Cadastro </a>
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
@endsection

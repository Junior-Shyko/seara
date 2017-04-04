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
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    <h1>Esqueci a Senha</h1>
                    {{ csrf_field() }}
                    
                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Digite seu e-mail">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Enviar Link de Acesso
                            </button>
                        </div>
                    </div>
                    <div class="separator">
                        <p class="change_link">Você tem uma senha?
                            <a href="{{ url('/login') }}" class="to_register"> Login </a>
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
@extends('layouts.blank')
@push('stylesheets')
<!-- Example -->
<!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
{{Html::style('css/home.min.css')}}
<style type="text/css">
    .ui-button ui-corner-all ui-widget{
    float: left;
    }
</style>
@endpush
@section('main_container')
<div class="col-md-12">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        @include('msg.message')
    </div>
    <div class="col-md-4"></div>
</div>
<!-- page content -->
<div class="right_col" role="main">
    <div class="row top_tiles">
        {{-- 
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="count">{{count($tot_users)}}</div>
                <h3>Usuários</h3>
                <p>Total de usuário em geral.</p>
            </div>
        </div>
        --}}
        
        <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="tile-stats">
              <div class="col-md-6">
                <h3 style="color: #1F5D8C; font-size: xxx-large; font-family: system-ui;">
                  Seara Contabilidade
                </h3>
                <p>Sistema de Gestão para igrejas</p>
              </div>
              <div class="col-md-6">
                <p>
                  <img src="https://searacontabilidade.com.br/wp-content/uploads/2019/01/cropped-seara_contabilidade-4.png" alt="" srcset="">
                </p>
              </div>
            </div>
        </div>
        
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-money"></i></div>
                <div class="count">Caixa</div>
                <h3>
                  <a href="{{url('lancar')}}" class="btn btn-primary">Lançar</a>
                </h3>
                <p>Lançar movimento</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
            <div class="count">{{$tot_recibos}}</div>
            <h3>Recibos</h3>
            <p>Total de recibos do mês.</p>
          </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-check-square-o"></i></div>
            <div class="count">{{$valor_recibos}}</div>
            <h3>Recibos</h3>
            <p>Valor total dos recibos emitidos no mês.</p>
          </div>
        </div>
    </div>
    <div class="col-md-6">
        {{-- <div class="x_panel">
            <div class="x_title">
                <h2>Aviso <small> Informações da Seara Contabilidade</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content bs-example-popovers">
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>22/05/2017</strong> Agradecemos a Você por está participando da nossa versão Beta.
                </div>
            </div>
        </div> --}}
    </div>
    <div class="col-md-6">
        <div class="">
            {{-- <div class="x_panel">
                <div class="x_title">
                    <h2>Tira dúvidas<small>Contato direto com a Seara Contabilidade</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="alerts"></div>
                    <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a data-edit="fontSize 5">
                                        <p style="font-size:17px">Huge</p>
                                    </a>
                                </li>
                                <li>
                                    <a data-edit="fontSize 3">
                                        <p style="font-size:14px">Normal</p>
                                    </a>
                                </li>
                                <li>
                                    <a data-edit="fontSize 1">
                                        <p style="font-size:11px">Small</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                            <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                            <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                            <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                            <div class="dropdown-menu input-append">
                                <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                <button class="btn" type="button">Add</button>
                            </div>
                            <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                            <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                        </div>
                    </div>
                    <div id="editor" class="editor-wrapper"></div>
                    <textarea name="descr" id="descr" style="display:none;"></textarea>
                    <br />
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resizable Text area</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="resizable_textarea form-control" placeholder="This text area automatically resizes its height as you fill in more text courtesy of autosize-master it out..."></textarea>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!-- /page content -->
@push('scripts')
<script>
    var base_url = "{{ url('') }}"
</script>
<script src="{{ asset("js/home.min.js") }}"></script>
@endpush
@endsection
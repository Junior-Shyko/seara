@extends('layouts.blank')

@push('stylesheets')
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">

            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Categorias de Receita <small>gerenciamento de categorias de receita</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12">
                        <button id="create-income-category-btn" class="btn btn-primary pull-right" data-cy="create-btn">Cadastrar Categoria</button>
                    </div>
                    <div class="x_content">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" data-cy="table" id="table-income-category">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Criado em</th>
                                            <th>Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /page content -->

    @include('modals.financing.income_category.create')

@endsection

@push('scripts')
    <script type="text/javascript" language="javascript" src="{{elixir('js/financing/income_category.min.js')}}"></script>
@endpush

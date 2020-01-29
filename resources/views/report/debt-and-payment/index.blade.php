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
                        <h2 data-cy="title">Relatório <small>dívidas e pagamentos</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="panel">
                            <div class="panel-body">
                                <form action="{{ url('report/debt-and-payment') }}" method="post" target="_blank">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="companies">Cliente</label>
                                        <select name="company_id" id="companies" class="form-control select2">
                                            @foreach($companies as $company)
                                                <option value="{{ $company->company_id }}">
                                                    {{ $company->company_manager }} / {{ $company->company_name ?? $company->company_fantasy }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Gerar Relatório</button>
                                    </div>
                                </form>
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
@endsection

@push('scripts')
@endpush

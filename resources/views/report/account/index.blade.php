@extends('layouts.blank')

@push('stylesheets')
@endpush

@section('main_container')
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 data-cy="title">Relatório <small>Relatório de contas por período</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    @if (session('error'))
                                        <div class="alert alert-error alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            {{-- <form action="{{url('relatorio/todas-contas')}}" method="POST"> --}}
                                <form action="{{url('financial/reports/by-category')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nome da conta</labedl>
                                    <select name="entries_id_account" id="cod_account" name="account" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">
                                            {{ $account->accountlaunch_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="">Data Inicial</label>
                                        <input type="text" name="dateInitial" value="{{$startMonthFormated}}"
                                         class="form-control date-mask" id="dateInitial">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Data Final</label>
                                        <input type="text" name="dateEnd" value="{{$endMonthFormated}}" class="form-control date-mask" id="dateEnd">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12" style="margin-top: 10px">                                      
                                        @role('superAdmin')
                                        <div class="form-group">
                                            <label>Nome da igreja</label>
                                            @if($company->company_fantasy == 'SEARA CONTABILIDADE')
                                            <select name="company_id" id="cod_account" name="account" class="form-control select2">
                                                <option value=""></option>
                                                @foreach($companyAll as $company)
                                                <option value="{{ $company->company_id }}">
                                                    {{ $company->company_fantasy }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        @else
                                            <input type="hidden" name="company_id" value="{{Auth::user()->user_id_company}}">
                                        @endrole
                                        <button type="submit" class="btn btn-primary btn-block">Pesquisar</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
   
</div>
@endsection

@push('scripts')
@endpush

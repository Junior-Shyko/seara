@extends('layouts.blank')
@push('stylesheets')
    <!-- Example -->
    <link href="{{ url('css/entry.min.css') }}" rel="stylesheet">
@endpush
@section('main_container')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                  <form action="" method="get" class="form-group">
                      <input type="text" class="form-control">
                  </form>
              </div>
            </div>
          </div>
        
    </div>
    <!-- /page content -->
   
    @component('components.modal_delete_comp')
        <form action="{{ url('launch/account/delete') }}" method="POST">
            {!! csrf_field() !!}
            <p>
            <h4 class="text-danger">
                Deseja realmente excluir essa conta do movimento de Caixa?
            </h4>
            </p>
            <p>
            <h4 id="nameAccountDeleteModal">Conta: </h4>
            <h4 id="typeAccountDeleteModal">Tipo da Conta: </h4>
            </p>
            <input type="hidden" name="id" id="idAccountLaunch">
            <input type="hidden" name="table" value="account_launches">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="submit" class="btn btn-danger"> EXCLUIR </button>
            </div>
        </form>
    @endcomponent
@endsection
@push('stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/receipt.min.css')}}"> --}}
@endpush
@push('scripts')
    <script type="text/javascript" language="javascript" src="{{ asset('js/launch/account_launch.min.js') }}"></script>
    {{-- <script type="text/javascript" language="javascript" src="{{asset('js/receipt-common.min.js')}}"></script> --}}
@endpush

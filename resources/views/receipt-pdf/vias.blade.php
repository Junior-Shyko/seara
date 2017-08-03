@extends('receipt-pdf.receipt')

@section('receipt_content')

	@include('receipt-pdf.receipt_content')

	@if( $vias == 2 )
		
		<div style="height: 10px;"></div>
	
		@include('receipt-pdf.receipt_content')

	@endif

@endsection

@extends('receipt-pdf.receipt')

@section('receipt_content')

	<div style="height: 10px;"></div>

	@include('receipt-pdf.receipt_content')

	@if( $vias == 2 )
		
		<div style="height: 20px;"></div>
	
		@include('receipt-pdf.receipt_content')

	@endif

@endsection

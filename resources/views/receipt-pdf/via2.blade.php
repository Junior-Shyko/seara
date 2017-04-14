@extends('receipt-pdf.receipt')

@section('receipt_content')

<div class='container'>
  @include('receipt-pdf.receipt_content')
</div>

<div class='container' id="segundaVia">
  @include('receipt-pdf.receipt_content')
</div>

@endsection

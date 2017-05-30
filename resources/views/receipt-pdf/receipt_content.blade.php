  <img src="{{url('img/logo/'.$company->company_brand_logo)}}">
  <div class="title">
    <h3 class="receipt">RECIBO </h3>
    <h3 class="value" style="">VALOR: R$ {{ number_format($receipt->receipt_value,2,',','.') }} </h3>
  </div>
  <div class="first-section">
    <p><strong>Recebi(emos) de:</strong> {{ $receipt->receipt_received_from }}</p>
    <p><strong>A importância de:</strong> {{ ucfirst($receipt->receipt_extensive_value) }}</p>
    <p><strong>Referente a:</strong> {{ $receipt->receipt_reference }}</p>
  </div>
  <div class="second-section">
    <p>Para maior clareza firmo(amos) o presente</p>
  </div>
  <div class="center">
    <p class="data"> {{ $receipt->receipt_local }}, {{ $receipt->extensiveDate() }}</p>
    <hr>
    <p class="contador">{{ $receipt->receipt_emitter }} {{ $receipt->receipt_document }}</p>
  </div>

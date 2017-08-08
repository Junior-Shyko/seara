<table border="0">
  <tr style="height: 99;">
    <td colspan="3">
      <img src="{{asset("img/logo/{$company->company_brand_logo}")}}" style="width: 100%; display: block;">
    </td>
    {{-- <td colspan="1"></td> --}}
    {{-- <td colspan="4" class="text-center"> --}}
      {{-- {!! nl2br(e($setting['setting_receipt_header'])) !!} --}}
    {{-- </td> --}}
    <td colspan="9" class="text-right">
      {!! nl2br(preg_replace('/\*\*\b(.+)\b\*\*/', '<b>$1</b>', e($setting['setting_receipt_header']))) !!}
      <div class="description">
        {{ ucwords($company->company_addr_street) }}, {{ $company->company_addr_number }} - {{ ucwords($company->company_addr_district) }}<br>
        CEP {{ preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '$1.$2-$3', $company->company_addr_cep) }} - {{ ucwords($company->company_addr_city) }} - {{ ucwords($company->company_addr_state) }}<br>
        {{ preg_replace('/^(\d{2})(\d?\d{4})(\d{4})$/', '($1) $2-$3', $company->company_phone) }} / {{ preg_replace('/^(\d{2})(\d?\d{4})(\d{4})$/', '($1) $2-$3', $company->company_mobile) }}<br>
        {{ $setting['setting_receipt_email'] }}<br>
      </div>
    </td>
  </tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  {{-- <tr><td colspan="12" class="offset-5"></td></tr> --}}
  <tr>
    <td colspan="4"></td>
    <td colspan="4" class="text-center">
      <h3>
        <strong>RECIBO</strong>
      </h3>
    </td>
    <td colspan="4" class="text-right">
      <h4>
        <strong>VALOR: R$ {{ number_format($receipt->receipt_value,2,',','.') }}</strong>
      </h4>
    </td>
  </tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr>
    <td colspan="3" class="text-bold top-align">Recebi(emos) de: </td>
    <td colspan="9" class="top-align">{{ mb_strtoupper($receipt->receipt_received_from) }}</td>
  </tr>
  <tr>
    <td colspan="3" class="text-bold top-align">A importância de: </td>
    <td colspan="9" class="top-align">{{ mb_strtoupper($receipt->receipt_extensive_value) }}</td>
  </tr>
  <tr>
    <td colspan="3" class="text-bold top-align">Referente a: </td>
    <td colspan="9" class="top-align">{{ mb_strtoupper($receipt->receipt_reference) }}</td>
  </tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr>
    <td colspan="12">Para maior clareza firmo(amos) o presente</td>
  </tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr>
    <td colspan="1"></td>
    <td colspan="10" class="text-center">{{ mb_strtoupper($receipt->receipt_local) }}, {{ mb_strtoupper($receipt->extensiveDate()) }}</td>
    <td colspan="1"></td>
  </tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr><td colspan="12" class="offset-5"></td></tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="6"><hr></td>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="6" class="text-center">{{ $receipt->receipt_emitter }} {{ $receipt->receipt_document }}</td>
    <td colspan="3"></td>
  </tr>
</table> 
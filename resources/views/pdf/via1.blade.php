<html>
<head>
<style>
.container {
  border: 1px solid black;
  font-size: 12pt;
}
#segundaVia {
  margin-top: 50px;
}
.center {
  text-align: center;
}
p {
  margin: 0 20px 10px;
  clear: both;
}
h2 {
  margin-top: 10px;
  font-size: 16pt
}
.valor {
  float: right;
  margin-right: 20px;
  margin-bottom: 0px;
  margin-top: 0px;
  font-size: 14pt;
  font-weight: bold;
}
hr {
  border-top: 1px solid black;
  width: 300pt;
  margin: 0px auto 5px;
}
.contador {
  margin: 0px 0px 20px;
}
img {
  width: 100%;
  height: auto;
}
.primeira-parte {
  margin: 10px 0px;
}
.primeira-parte p {
  margin-top: 3px;
  margin-bottom: 3px;
}
.segunda-parte {
  margin: 20px 0px 20px;
}
.data {
  margin-bottom: 40px;
}
</style>
</head>
<body>
  <div class='container'>
    <img src="{{asset('images/header.jpg')}}">
    <h2 class='center'>RECIBO</h2>
    <p class="valor">VALOR: R$ {{$receipt->receipt_value}}</p>
    <div class="primeira-parte">
      <p>Recebi(emos) de: {{$receipt->receipt_received_from}}</p>
      <p>A importância de: {{$receipt->receipt_extensive_value}}</p>
      <p>Referente a: {{$receipt->receipt_reference}}</p>
    </div>
    <div class="segunda-parte">
      <p>Para maior clareza firmo(amos) o presente</p>
    </div>

    <div class="center">
      <p class="data">{{$receipt->receipt_date}}</p>
      <hr>
      <p class="contador">{{$receipt->receipt_emitter}} {{$receipt->receipt_document}}</p>
    </div>
  </div>
</body>
</html>

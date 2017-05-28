<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ReceiptCompany;
use App\Seara\Monetary;
use Yajra\Datatables\Facades\Datatables;
use Exception;

use PDF;

class ReceiptCompanyController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $company = Auth::user()->company;
    return view('receipt-company.index', compact('company'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //

    return view('receipt-company.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    try {
      $request['receipt_extensive_value'] = Monetary::numberToExt($request['receipt_value']);
      $receipt = ReceiptCompany::create($request->all());
    }
    catch(Exception $e) {
      $errorCode = 400;
      return response(['status' => 'error', 'code' => $errorCode, 'message' => $e->getMessage()], $errorCode);
    }

    return response(['status' => 'success', 'message' => "O recibo foi criado!"]);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(ReceiptCompany $receipt_company)
  {
    $receiptArray = $receipt_company->toArray();
    // $receiptArray['receipt_date'] = $recibo_empresa->receipt_date->format('d/m/Y');
    $receiptArray['receipt_date'] = $receipt_company->receipt_date->toDateString();
    return response()->json($receiptArray);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, ReceiptCompany $receipt_company)
  {
    try {
      $receipt_company->fill($request->all());
      $receipt_company->save();
    }
    catch(Exception $e) {
      $errorCode = 400;
      return response(['status' => 'error', 'code' => $errorCode, 'message' => $e->getMessage()], $errorCode);
    }


    return response(['status' => 'success', 'message' => "O recibo foi atualizado!"]);

  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(ReceiptCompany $receipt_company)
  {
    // Tentar excluir
    try {

      $receipt_company->delete();

    } catch (Exception $e) {

      $errorCode = 400;
      return response(['status' => 'error', 'code' => $errorCode, 'message' => $e->getMessage()], $errorCode);

    }

    return response(['status' => 'success', 'message' => "O recibo foi excluído!"]);

  }

  public function generatePDF(Request $request, ReceiptCompany $receipt)
  {
    $pdf_name = 'recibo-'.$receipt->receipt_date.'.pdf';
    ini_set('memory_limit', '-1');
    switch($request->vias)
    {
      case 1:

      $pdf =PDF::loadView('receipt-pdf.via1', compact('receipt'));
      $pdf->setPaper('A4', 'report');
      $pdf->output();
      $dom_pdf = $pdf->getDomPDF();

      $canvas = $dom_pdf ->get_canvas();
      /*page_text(pos_horizontal,pos_vertical , texto , null , tamanho, cor_em_rgb)
      */
      $canvas->page_text(530, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

      return $pdf->stream($pdf_name);

      break;

      case 2:
      return PDF::loadView('receipt-pdf.via2', compact('receipt'))->stream($pdf_name);
      break;
    }

    // Caso a requisição seja inválida, retorno para a lista de recibos
    return redirect('/recibo-empresa');
  }

  public function anyData()
  {
    $receipts = ReceiptCompany::select(
      [
        'receipt_id',
        'receipt_received_from',
        'receipt_reference',
        'receipt_value',
        'receipt_local',
        'receipt_date'
      ]
    );

    return Datatables::of($receipts)
    ->addColumn(
      'action',
      function ($receipt) {
        return $this->actions($receipt->receipt_id);
      })
      ->editColumn('receipt_value', function ($receipt){
        return 'R$ '.number_format($receipt->receipt_value, 2, ',', '.');
      })
      ->editColumn('receipt_date', function($receipt){
        return $receipt->receipt_date->format('d/m/Y');
      })
      ->editColumn('receipt_local', function($receipt){
        return ucfirst($receipt->receipt_local);
      })
      ->make(true);
    }

    private function actions($id)
    {
      return $this->actionEdit($id)
      .$this->actionClone($id)
      .$this->actionDelete($id)
      .$this->actionDownload($id, 1)
      .$this->actionDownload($id, 2);
    }

    private function actionEdit($id)
    {
      return "<button class='btn btn-primary btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Editar Recibo' onclick='editReceipt( {$id} )'> <i class='fa fa-pencil'></i> </button>";
    }

    private function actionClone($id)
    {
      return "<button class='btn btn-primary btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Clonar Recibo' onclick='cloneReceipt( {$id} )'> <i class='fa fa-clone'></i> </button>";
    }

    private function actionDelete($id)
    {
      return "<button class='btn btn-danger btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Excluir Recibo' onclick='deleteReceipt( {$id} )'> <i class='fa fa-trash-o'></i> </button>";
    }

    private function actionDownload($id, $vias)
    {
      $url = ("receipt-company/{$id}/pdf?vias={$vias}");
      return "<a href='{$url}' target='_blank' class='btn btn-info btn-xs'><i class='fa fa-print'></i> {$vias} Via </a>";
    }
  }

<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\Models\ReceiptCommon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ReceiptCompany;
use App\Seara\Monetary;
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
        $date = Carbon::now()->format('d/m/Y');      //
        $receipts = ReceiptCompany::all();
        return view('receipt-company.index', compact('company','date','receipts'));
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
        return redirect()->back()->with('error' , 'Ocorreu um erro: '.$e->getMessage());
      }

      return redirect()->back()->with('success' , 'Recibo cadastrado com sucesso!');
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
        return redirect()->back()->with('error' , 'Ocorreu um erro: '.$e->getMessage());
      }

      return redirect()->back()->with('success' , 'Recibo atualizado com sucesso!');
      //
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
        return redirect()->back()->with('error' , 'Ocorreu um erro: '.$e->getMessage());
      }

      return redirect()->back()->with('success' , 'Recibo excluído com sucesso');
    }

    public function generatePDF(Request $request, ReceiptCompany $receipt)
    {
      $pdf_name = 'recibo-'.$receipt->receipt_date.'.pdf';
      switch($request->vias)
      {
        case 1:
          return PDF::loadView('receipt-pdf.via1', compact('receipt'))->stream($pdf_name);
        break;

        case 2:
          return PDF::loadView('receipt-pdf.via2', compact('receipt'))->stream($pdf_name);
        break;
      }

      // Caso a requisição seja inválida, retorno para a lista de recibos
      return redirect('/recibo-empresa');
    }
}

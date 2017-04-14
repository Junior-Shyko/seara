<?php

namespace App\Http\Controllers;

use App;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ReceiptCompany;
use App\Seara\Monetary;
use Exception;

use PDF;

class ReceiptCompanyController extends Controller
{
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
        $receipt = ReceiptCompany::create($request->all());
        $receipt->receipt_extensive_value = Monetary::numberToExt($receipt->receipt_value);
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
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

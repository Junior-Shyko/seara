<?php

namespace App\Http\Controllers;

use App\Service\Receipt\CreateReceipt;
use App\Service\Receipt\GenerateReceiptPdf;
use Auth;
use Exception;
use PDF;
use DB;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

use App\Seara\Monetary;

use App\Models\ReceiptCompany;
use App\Models\Company;
use App\Models\Setting;

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
  	$settings = $this->getReceiptSettings();

  	return view('receipt-company.index', compact('company', 'settings'));
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
     * @param \Illuminate\Http\Request $request
     * @param CreateReceipt $createReceipt
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request, CreateReceipt $createReceipt)
  {
  	try {
  	    $createReceipt->execute($request->all());
        return response(['status' => 'success', 'message' => "O recibo foi criado!"]);
  	} catch(Exception $e) {
  		$errorCode = 400;
  		return response(['status' => 'error', 'code' => $errorCode, 'message' => $e->getMessage()], $errorCode);
  	}
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
  		$request['receipt_extensive_value'] = Monetary::numberToExt($request['receipt_value']);
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

  public function generatePDF(Request $request, ReceiptCompany $receipt, GenerateReceiptPdf $generateReceiptPdf)
  {
      return $generateReceiptPdf->execute(
          (int) $request->vias,
          $receipt
      );
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
  	)
  	->where('receipt_id_company',  Auth::user()->user_id_company)
  	->orderBy('receipt_id', 'desc');

  	return Datatables::of($receipts)
  	->addColumn(
  		'action',
  		function ($receipt) {
  			return $this->actions($receipt->receipt_id);
  		}
  	)
  	->editColumn('receipt_value', function ($receipt){
  		return 'R$ '.number_format($receipt->receipt_value, 2, ',', '.');
  	}	
  	)
  	->editColumn('receipt_date', function($receipt){
  		return $receipt->receipt_date->format('d/m/Y');
  	}
  	)
  	->editColumn('receipt_local', function($receipt){
  		return ucfirst($receipt->receipt_local);
  		}
  	)
  	->make(true);
  }
	
	public function getReceiptSettings()  
	{
		$company = Auth::user()->company;

		$setting = Setting::where('setting_id_company', $company->company_id)->first();

		if ( is_null($setting) )
		{
			$setting = [
				'setting_id_company' => $company->company_id,
				'setting_receipt_local' => ucwords($company->company_addr_city),
				'setting_receipt_emitter' => ucwords($company->company_fantasy),
				'setting_receipt_document' => preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $company->company_cnpj),
				'setting_receipt_email' => '',
				'setting_receipt_header' => $company->company_fantasy
			];

			$setting = Setting::create($setting);
		}

		return $setting->toArray();
	}

	public function storeReceiptSettings(Request $request)
	{	
		$company_id = $request->input('setting_id_company');

		$setting_data = [
			'setting_receipt_document' => $request->input('setting_receipt_document'),
			'setting_receipt_email' => $request->input('setting_receipt_email'),
			'setting_receipt_emitter' => $request->input('setting_receipt_emitter'),
			'setting_receipt_header' => $request->input('setting_receipt_header'),
			'setting_receipt_local' => $request->input('setting_receipt_local')
		];

		$response = [];
		$code = 200;

		try {
			$setting = Setting::where('setting_id_company', $company_id)->first();
			$setting->fill($setting_data);
			$setting->save();

			$response['status'] = 'success';
			$response['message'] = 'Configurações salvas com sucesso!';
		}
		catch (Exception $e) {
			$response['status'] = 'error';
			$response['message'] = 'Configurações não salvas, tente novamente!';
		}

		return response($response, $code);
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

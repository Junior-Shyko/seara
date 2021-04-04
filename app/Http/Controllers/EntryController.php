<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use App\FileLaunch;
use App\FunctionGeneral;
use App\Seara\Monetary;
use App\AccountLaunch;
use Auth, DB, PDF;
use Validator, Datatables;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Carbon\Carbon;
use App\AccountType;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = AccountLaunch::get();
        $month = Carbon::now()->month;
        $monthPlus = ($month - 1);
        
        $typeEnd = DB::table('account_types')->where('account_types_name', 'Despesa')->get();
        
        $bankReceita = Monetary::getValueBoxFeed($typeEnd[0]->id, true, Auth::user()->user_id_company);
        $bankDespesa = Monetary::getValueBoxFeed(null, true, Auth::user()->user_id_company);
        $totBanco = ($bankReceita - $bankDespesa);
        // dump($bankReceita);
        // dump($bankDespesa);
        // dump($totBanco);
        // dump("--");
        $igrejaReceita = Monetary::getValueBoxFeed($typeEnd[0]->id, false, Auth::user()->user_id_company);
        $igrejaDespesa = Monetary::getValueBoxFeed(null, false, Auth::user()->user_id_company);
        
        // dump($igrejaReceita);
        // dump($igrejaDespesa);
        $totIgreja = ($igrejaReceita - $igrejaDespesa);
        // dump($totIgreja);
        // dump("--");
        $saldoGer = Monetary::getValueBox();
        $saldo = ($saldoGer['receitas'] - $saldoGer['despesas']);
        // dump($saldo);
        
        return view('entry.index', compact('accounts', 'saldo' , 'totIgreja', 'totBanco'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules = [
            'entries_description' => 'required',
            'entries_id_account' => 'required',
            'entries_value' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );

        if ( $validator->fails() )
        {
            $messages = $validator->errors()->all();
            return response( ['status' => 'error', 'message' => "Todos os campos são obrigatórios"], 422 );
        }
        
        $date_launch = FunctionGeneral::DataBRtoMySQL($request->entries_date_launch);
        $request['entries_date_launch'] = $date_launch;

        try {
            $reques = Monetary::money_real($request['entries_value']);
            $request['entries_value'] = $reques;
            $entry = Entry::create($request->all());
            $name = AccountType::getNameType($request['entries_id_account']);
            return response()->json([
                'message' => 'Conta lançada',
                'status' => 'success',
                'id'=>$entry->entries_id,
                'typeAccount' => $name],200);
        } catch (BadResponseException $e) {
            dump($e->getMessage());
        }
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
        $launch =  Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
        ->join('account_types', 'account_launches.accountlaunch_type', '=','account_types.id')
        ->join('users', 'entries.entries_id_user', '=', 'users.id')
        ->where('entries.entries_id','=',$id)
        ->select('entries.*', 'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.created_at as createEntry', 'users.name as nameUser')
        ->get();
        $files = FileLaunch::where('file_launches_id_entry','=',$id)->get();
        $accounts = AccountLaunch::get();
        return view('entry.edit', compact('id','launch', 'files', 'accounts'));
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
        $val = Monetary::money_real($request['entries_value']);
        $request['entries_value'] = $val;
        $rules = [
            'entries_description' => 'required',
            'entries_id_account' => 'required',
            'entries_value' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );

        if ( $validator->fails() )
        {
            $validator->errors()->all();
            return response( ['status' => 'error', 'message' => "Todos os campos são obrigatórios"], 422 );
        }
        $date_launch = FunctionGeneral::DataBRtoMySQL($request['entries_date_launch']);
        $request['entries_date_launch'] = $date_launch;

        $input = $request->all();
        $input = $request->except('_method' , '_token');
        try {
            Entry::where('entries_id' , $id)->update($input);
            return redirect()->back()->with('success' , 'Lançamento alterado com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->with('error' ,  'Ocorreu um erro');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $files = FileLaunch::where('file_launches_id_entry','=',$request->id)->get();

        foreach ($files as $key => $value) {
            FileLaunch::where('id',$value->id)->delete();
        }
        try {
            $entry = Entry::where('entries_id' , $request->id)->delete();
            return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro!');
        }
    }

    public function upload(Request $request) {
        $user = Auth::user();
        
        $total = count($_FILES['file']['name']);
        $totalFile = 0;
        $uploadSuccess = false;
        // // Loop through each file
        for( $i=0 ; $i < ($total) ; $i++ ) {
            $totalFile++;
          //Get the temp file path
          $tmpFilePath = $_FILES['file']['tmp_name'][$i];
            
          //Make sure we have a file path
            if ($tmpFilePath != ""){
            //Setup our new file path
                $newFilePath = "./img/images/" . $_FILES['file']['name'][$i];
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
               
                // //Upload the file into the temp dir
                $datetime = Carbon::now();
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                $newNameFile = base64_encode($datetime.'-'.$_FILES['file']['name'][$i]);
                if(move_uploaded_file($tmpFilePath, "./img/images/" .$newNameFile.'.'.$ext)) {
                    
                    FileLaunch::insert([
                        'file_launches_name' => $newNameFile.'.'.$ext, 
                        'file_launches_id_entry' => $request->idEntry,
                        'created_at' => $datetime,
                        'updated_at' => $datetime
                    ]);
                    if($totalFile == $total){
                        $uploadSuccess = true;
                    }
                    //return response()->json(['message' => 'success', 'status' => 'success'], 200);

                }
            }
        }
        if($uploadSuccess) {
            return response()->json(['message' => 'Arquivo enviado com sucesso', 'status' => 'success'], 200);
        }else{
            return response()->json(['message' => 'Ocorreu um erro inesperado, tente novamente mais tarde', 'status' => 'error'], 500);
        }
       
    }

    public function getAll(Request $request) {

        $dtIni = $request->dtIni;
        $dtEnd = $request->dtEnd;
        if(isset($request->dtIni) && empty($request->dtIni)) {
            $startDate = Carbon::now();
            $dtIni = $startDate->startOfMonth();  
        }elseif(!isset($request->dtIni)) {
            $startDate = Carbon::now();
            $dtIni = $startDate->startOfMonth(); 
        }
        if(isset($request->dtEnd) && empty($request->dtEnd)) {
            $endDate = Carbon::now();
            $dtEnd = $endDate->startOfMonth(); 
        }elseif(!isset($request->dtEnd)) {
            $endDate = Carbon::now();
            $dtEnd = $endDate->lastOfMonth(); 
        }
        //DB::enableQueryLog();
        $mov = Entry::join('users', 'entries.entries_id_user', '=', 'users.id')
                ->join('account_launches','entries.entries_id_account','=','account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                ->where('entries.entries_date_launch','>=', $dtIni)
                ->where('entries.entries_date_launch','<=', $dtEnd)
                ->where('entries.entries_id_company','=',Auth::user()->user_id_company)
                ->select('users.id as idUser', 'users.name', 'entries.*', 'account_launches.accountlaunch_type', 'account_types.account_types_name')
                ->orderBy('entries.entries_date_launch', 'asc')
                ->get();
        //dd(DB::getQueryLog());
        return Datatables::of($mov)->addIndexColumn()
            ->editColumn('entries_date_launch', function ($mov) {
                $date = new Carbon($mov->entries_date_launch);
                return $date->format('d/m/Y');
            })
            ->editColumn('entries_id_user', function ($mov) {
                return $mov->name;
            })
            ->editColumn('entries_value', function ($mov) {
                return number_format($mov->entries_value,2,',','.');
            })
            ->editColumn('entries_id_account', function ($mov) {
                return $mov->account_types_name;
            })
            ->addColumn('action', function ($mov) {
                return '<a href="'.url('lancar/'.$mov->entries_id.'/edit').'" class="btn btn-primary btn-xs" type="button" title="Editar Registro">
                <i class="fa fa-edit"></i></a>
                <button class="btn btn-dark btn-xs" type="button" title="Informação do Registro"
                data-toggle="modal"
                data-id="'.$mov->entries_id.'"
                data-day="'.$mov->entries_day.'"
                data-his="'.$mov->entries_description.'"
                data-val="'.$mov->entries_value.'"
                data-target="#modalInfoLaunch">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                <button class="btn btn-danger btn-xs" type="button" title="Excluir Registro"
                data-toggle="modal"
                data-id="'.$mov->entries_id.'"
                data-name="'.$mov->entries_description.'"
                data-type="'.$mov->account_types_name.'"
                data-target="#modalDeleteComponent">
                <i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['entries_description', 'action'])
            ->make(true);
    }

    public function info($id) {
        //Entry::join('users', 'entries.entries_id_user', '=', 'users.id')
        $file = FileLaunch::where('file_launches_id_entry', $id)->get();

        if(count($file) > 0){
            $info = Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=','account_types.id')
            ->join('users', 'entries.entries_id_user', '=', 'users.id')
            ->join('file_launches', 'file_launches.file_launches_id_entry','=','entries.entries_id')
            ->where('entries.entries_id','=',$id)
            ->select('entries.*', 'file_launches.*', 'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.created_at as createEntry', 'users.name as nameUser')
            ->get();
        }else{
            $info = Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=','account_types.id')
            ->join('users', 'entries.entries_id_user', '=', 'users.id')
            ->where('entries.entries_id','=',$id)
            ->select('entries.*',  'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.entries_date_launch as createEntry', 'users.name as nameUser')->get();
        }
        
        return $info;
    }

    public function deleteFile(Request $request) {
        $file = FileLaunch::find($request->id);
        $file->delete();
        $filename = public_path('img/images/'.$file->file_launches_name);
        if (file_exists($filename) ) {
           if( unlink($filename) ) {
            return redirect()->back()->with('success', 'Arquivo Excluído com sucesso');
           }
        }
    }

    public function bank() {
        $typeEnd = DB::table('account_types')->where('account_types_name', 'Despesa')->get();
        
        $bankReceita = Monetary::getValueBoxFeed($typeEnd[0]->id, true, Auth::user()->user_id_company);
        $bankDespesa = Monetary::getValueBoxFeed(null, true, Auth::user()->user_id_company);
        $totBanco = ($bankReceita - $bankDespesa);
        return response()->json($totBanco);
    }

    public function internal() {
        $typeEnd = DB::table('account_types')->where('account_types_name', 'Despesa')->get();
        $igrejaReceita = Monetary::getValueBoxFeed($typeEnd[0]->id, false, Auth::user()->user_id_company);
        $igrejaDespesa = Monetary::getValueBoxFeed(null, false, Auth::user()->user_id_company);

        $totIgreja = ($igrejaReceita - $igrejaDespesa);
        return response()->json($totIgreja);
    }

    public function general() {
        $saldoGer = Monetary::getValueBox();
        $saldo = ($saldoGer['receitas'] - $saldoGer['despesas']);
        return response()->json($saldo);
    }

    public function reportBox($dateInit, $dateEnd) {
        
        $dtinit = FunctionGeneral::DataBRtoMySQL(base64_decode($dateInit));
        $dtend  = FunctionGeneral::DataBRtoMySQL(base64_decode($dateEnd));
        $per    = Monetary::getValueBoxPerPeriodo($dtinit, $dtend);
        $total  = ($per['receitas'] - $per['despesas']);

        $perInitial = base64_decode($dateInit);
        $perEnd = base64_decode($dateEnd);
        //VALOR DO SALDO ANTERIOR
        $prevBalan = Monetary::previousBalance($dtinit);
        $previousBalance = ($prevBalan['receitas'] - $prevBalan['despesas']);

        $entries = Entry::join('companies', 'entries.entries_id_company', '=', 'companies.company_id')
        ->join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
        ->join('account_types', 'account_launches.accountlaunch_type', '=','account_types.id')
        ->where('entries_date_launch', '>=', $dtinit)
        ->where('entries_date_launch', '<=', $dtend)
        ->where('companies.company_id', '=', Auth::user()->user_id_company)
        ->orderBy('entries_date_launch', 'asc')->get();
        
        // $pdf = PDF::loadView('entry.report.perPeriod', compact('entries', 'perInitial', 'perEnd', 'total'));
        // $pdf->setOptions([
        //     'isHtml5ParserEnabled' => true,
        //     'isRemoteEnabled' => true,
        //     'defaultPaperSize' =>  'a4']); 
        // return $pdf->stream();
        //dd($entries);
        return view('entry.report.perPeriod', compact('entries', 'perInitial', 'perEnd',  'total' , 'previousBalance'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use App\FileLaunch;
use App\FunctionGeneral;
use App\Seara\Monetary;
use App\AccountLaunch;
use Auth, DB;
use Validator, Datatables;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Carbon\Carbon;

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

        
        $typeEnd = DB::table('account_types')->where('account_types_name', 'Despesa')->get();
        $monthPlus = ($month - 1);
        $totPlus = Monetary::getValuePerMonth($monthPlus , $typeEnd[0]->id);
        $totNeg = Monetary::getValuePerMonth($monthPlus);
        
        $totalGeral = ($totPlus - $totNeg);
        
        $actualPos = Monetary::getValuePerMonth($month , $typeEnd[0]->id);
        $actualNeg = Monetary::getValuePerMonth($month);
        $monthActual = ($actualPos - $actualNeg);
        $currentBalance = ($monthActual + $totalGeral);
       
        return view('entry.index', compact('accounts', 'totalGeral', 'monthActual', 'actualPos', 'actualNeg','currentBalance'));
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

        if($request->type == 'retroactive') {
            $timeCarbon = Carbon::now();
            $time = $timeCarbon->format('H:i:s');

            $created_at = FunctionGeneral::DataBRtoMySQL($request->entries_day);
            $d    = Carbon::parse($created_at);
            $d->format('l');
            
            //dump($d->format('d')); 
            $request['entries_day'] = $d->format('d');
            $request['entries_date_launch'] = $created_at.' '.$time;

        }else{
            $request['entries_date_launch'] = Carbon::now();
        }
        try {
            $reques = Monetary::money_real($request['entries_value']);
            $request['entries_value'] = $reques;
            $entry = Entry::create($request->all());

            return response()->json([
                'message' => 'Conta lançada',
                'status' => 'success',
                'id'=>$entry->entries_id],200);
        } catch (BadResponseException $e) {
            dump($e->getMessage());
        }

        // if($request->hasFile('file')){
        //     if($request->file('file')->isValid()){
        //         $nameUniqid = uniqid(date('HisYmd'));
        //         $extension = $request->file->extension();
        //         $nameFile = $nameUniqid.'_'.$user->user_id_company.'.'.$extension;
        //         $request->file->storeAs('box', $nameFile);
        //     }
        // }
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
       
        if(isset($request['entries_decimate']))
        {
            $entries_decimate                 = $request['entries_decimate'];    
            $request['entries_decimate']    = FunctionGeneral::moeda($entries_decimate );
        }
        if(isset($request['entries_offer']))
        {
            $entries_offer                 = $request['entries_offer'];    
            $request['entries_offer']    = FunctionGeneral::moeda($entries_offer );
        }
        if(isset($request['entries_other']))
        {
            $entries_other                 = $request['entries_other'];    
            $request['entries_other']    = FunctionGeneral::moeda($entries_other );
        }
        if(isset($request['entries_end']))
        {
            $entries_end                 = $request['entries_end'];    
            $request['entries_end']    = FunctionGeneral::moeda($entries_end );
        }
        

        $input = $request->all();
        $input = $request->except('_method' , '_token');
        
        try {
            $up_entry = Entry::where('entries_id' , $id)->update($input);
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

    public function getAll() {
        $month = Carbon::now()->month;

        $mov = Entry::join('users', 'entries.entries_id_user', '=', 'users.id')
                ->join('account_launches','entries.entries_id_account','=','account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                ->whereMonth('entries.entries_date_launch', $month)
                ->select('users.id as idUser', 'users.name', 'entries.*', 'account_launches.accountlaunch_type', 'account_types.account_types_name')
                ->orderBy('entries_day', 'asc')
                ->get();
        return Datatables::of($mov)->addIndexColumn()
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
                return '<button class="btn btn-primary btn-xs" type="button" title="Editar Registro">
                <i class="fa fa-edit"></i></button>
                <button class="btn btn-dark btn-xs" type="button" onclick="showInfo('.$mov->entries_id.')" title="Informação do Registro"
                data-day="'.$mov->entries_day.'"
                data-his="'.$mov->entries_description.'"
                data-val="'.$mov->entries_value.'">
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
        $info = Entry::join('file_launches', 'file_launches.file_launches_id_entry','=','entries.entries_id')
        ->join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
        ->join('account_types', 'account_launches.accountlaunch_type', '=','account_types.id')
        ->join('users', 'entries.entries_id_user', '=', 'users.id')
        ->where('entries.entries_id','=',$id)
        ->select('entries.*', 'file_launches.*', 'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.created_at as createEntry', 'users.name as nameUser')
        ->get();
        return $info;
    }
}

<?php

namespace Seara\Http\Controllers;

use Illuminate\Http\Request;
use Seara\Box;
use Seara\Entry;
use Seara\FunctionGeneral;
use Auth , DB;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *PARA MOSTRAR A QUERY COMPLETA
     * DB::enableQueryLog();
     * //return DB::getQueryLog();
     */
    public function index()
    {
        //CREATE 2017-06-2017 BY EXCELLENCE SOFT
        //UPDATE 2017-07-03
        $month = Carbon::now()->month;
       // DB::enableQueryLog();
        $box = Box::all();
        //return DB::getQueryLog();

        if(count($box) === 0)
        {

           $box = [];
           $value_previous  = [];
        
        }else{
            
            $box = Box::where(
            [
                ['boxies_id_company' , '=' , Auth::user()->user_id_company],
                ['boxies_status' , '=' , 'Aberto']
            ])->whereMonth('created_at', $month)->get();
            
            $balance_previous = Box::where('boxies_id_company' ,Auth::user()->user_id_company)->max('boxies_id');
            
            $value_previous = Box::where('boxies_id' , $balance_previous)->get();

        }    

        //dd($box);
        $type_account = DB::table('type_accounts')->where('type_accounts_id_company' , Auth::user()->user_id_company)->orderBy('type_accounts_id')
                                ->pluck('type_accounts_name','type_accounts_id');

        $entry = Entry::where('entries_id_company' , Auth::user()->user_id_company)->whereMonth('created_at', $month)->orderBy('entries_day')->get();
        
       
       return view('box.index' , compact('box' , 'type_account' , 'entry' , 'value_previous'));
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
        //Create 2017-06-11 by Excellence Soft - Junior Oliveira
        /*

        ESSE CÓDIGO DEVE ESTÁ NO ENTRYCONTROLLER

        */
        if($request->ajax())
        {
            $request['entries_id_users']           = Auth::user()->id;
            $request['entries_id_company']        =Auth::user()->user_id_company;
            //$request['boxes_balance_initial']   = FunctionGeneral::moeda($request['boxes_balance_initial']);
            //$request['boxes_balance_previous']  = FunctionGeneral::moeda($request['boxes_balance_initial']);
            $boxes_decimate                 = $request['entries_decimate'];    
            $request['entries_decimate']    = FunctionGeneral::moeda($boxes_decimate );
            
            $box_offer                      = $request['entries_offer'];
            $request['entries_offer']       = FunctionGeneral::moeda($box_offer);
            
            $boxes_other                    = $request['entries_other'];
            $request['entries_other']       = FunctionGeneral::moeda($boxes_other);

            $box_end                        = $request['entries_end'];
            $request['entries_end']         = FunctionGeneral::moeda($box_end);
            //$request['box_balance']             = FunctionGeneral::moeda($request['boxes_balance_initial']);
            //$request['box_balance_end']         = FunctionGeneral::moeda($request['boxes_balance_initial']);
            
                try {
                    $request->except('_token');
                    $input = $request->all();
                    
                    $box = Entry::create($input);

                    return response()->json(['message' , 'success']);

                } catch (Exception $e) {

                    return response()->json(['message' , 'error']);

                }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //2017-06-11
        $month = Carbon::now()->month;
        $box = Box::where(
            [
                ['boxies_id_company' , '=' , Auth::user()->user_id_company],
                ['boxies_status' , '=' , 'Aberto']
            ])->whereMonth('created_at', $month)->get(); 

        if(count($box) > 0)
        {
            //lançamento
            $launch = Entry::where('entries_id_company' , Auth::user()->user_id_company)->whereMonth('created_at', $month)->get();
            
           return response()->json($launch);
        }
        
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
    public function destroy(Request $request)
    {
        if($request->ajax()){
            try {
              
                $box = Entry::where('entries_id' , $request['entries_id'])->delete();
                return response()->json(['message' => 'success']);
            } catch (Exception $e) {
                return response()->json(['message' => 'Error: '.$e->getMessege()]);
            }
        }
    }

    public function balance_initial()
    {
        return view('box.setting');
    }

    public function open_box(Request $request)
    {
        $data_open = FunctionGeneral::DataBRtoMySQL($request['date_box_open']);
        $request['boxies_date_open'] = $data_open;
        $request['boxies_status'] = 'Aberto';
        $request['boxies_balance_end'] = 0.00;
        $initial = FunctionGeneral::moeda($request['boxies_balance_initial_modal']);
        $request['boxies_balance_initial'] = $initial;        

        try {
            
            $box = Box::create($request->all());
          
          
            return redirect()->back()->with('success' , 'Caixa Aberto com sucesso');

        } catch (Exception $e) {
            return $e->getMessege();
        }
        
        if($box)
        {
            dump($box);
            return "gravado";

        
        }
        

    }

    public function close_box(Request $request)
    {
        try {
            $close = Box::find($request['boxies_id']);

            $request->except('_token');
            $input = $request->all();

            $close->boxies_status = 'Fechado';
            $close->boxies_balance_end = $input['boxies_balance_end'];
            $close->boxies_date_close = Carbon::now();  
            $close->save();
            return redirect()->back()->with('success' , 'Caixa Fechado com sucesso');
        } catch (Exception $e) {
            return $e->getMessege();
        }

    }
}

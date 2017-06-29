<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Box;
use App\Entry;
use App\FunctionGeneral;
use Auth , DB;
use Carbon\Carbon;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //CREATE 2017-06-2017 BY EXCELLENCE SOFT
        $box = Box::where('boxies_id_company' , Auth::user()->user_id_company)->get();

        $type_account = DB::table('type_accounts')->where('type_accounts_id_company' , Auth::user()->user_id_company)->orderBy('type_accounts_id')
                                ->pluck('type_accounts_name','type_accounts_id');

        $entry = Entry::where('entries_id_company' ,  Auth::user()->user_id_company)->get();
        return view('box.index' , compact('box' , 'type_account' , 'entry' ));
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
        //lançamento
        $month = Carbon::now()->month;
        //DB::enableQueryLog();
        $launch = Entry::where('entries_id_company' , Auth::user()->user_id_company)->whereMonth('created_at', $month)->get();
        //return DB::getQueryLog();
        return response()->json($launch);

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
                $box  = Box::find($request['boxes_id']);
                $box->delete();
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
          
          
            return "Cadastrado";

        } catch (Exception $e) {
            return $e->getMessege();
        }
        
        if($box)
        {
            dump($box);
            return "gravado";

        
        }
        

    }
}

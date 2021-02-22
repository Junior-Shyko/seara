<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use App\FunctionGeneral;
use App\AccountLaunch;
use Auth, DB;
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
        $total = Entry::whereMonth('created_at', $month-1)->whereNotIn('accountlaunch_type',[$typeEnd[0]->id])->get();
        $totalPrevius = $total->sum('entries_value');

        return view('entry.index', compact('accounts', 'totalPrevius'));
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
        try {
            $entry = Entry::create($request->all());
            return response()->json([
                'message' => 'Conta lançada',
                'status' => 'success',
                'id'=>$entry->id],200);
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
    public function destroy($id)
    {
        
        try {
            $entry = Entry::where('entries_id' , $id)->delete();
            return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro!');
        }
    }

    public function upload(Request $request) {
        $user = Auth::user();
        if($request->hasFile('file')){
            if($request->file('file')->isValid()){
                $nameUniqid = uniqid(date('HisYmd'));
                $extension = $request->file->extension();
                $nameFile = $nameUniqid.'_'.$user->user_id_company.'.'.$extension;
                $request->file->storeAs('box', $nameFile);
            }
        }
        
        return response()->json(['message' => 'success', 'status' => 'success'], 200);
    }
}

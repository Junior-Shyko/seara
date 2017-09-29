<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use App\FunctionGeneral;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
}

<?php

namespace Seara\Http\Controllers;

use Seara\TypeBank;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class TypeBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('typebank.index');
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
        if(isset($request->id_bank) )
        {
            TypeBank::where('id', '=', $request->id_bank)->update(['name' => $request->name]);return response()->json(['message' => 'Tipo bancário atualizado com sucesso', 'type' => 'success','status' => 200], 200);
        }else{
            $input = ['name' => $request->name];
            TypeBank::create($input);
            return response()->json(['message' => 'Tipo bancário cadastrado', 'type' => 'success','status' => 200], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\TypeBank  $typeBank
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            $typeBank = TypeBank::findOrFail($id);
            return response()->json($typeBank);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\TypeBank  $typeBank
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeBank $typeBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\TypeBank  $typeBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeBank $typeBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\TypeBank  $typeBank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            TypeBank::find($id)->delete();
            return response()->json(['message' => 'Tipo de conta bancária excluida com sucesso', 'type' => 'success','status' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocorreu um erro : '.$th->getMessage(), 'type' => 'error','status' => 400], 400);
        }
    }

    public function getType()
    {
        $bank = TypeBank::all();
        return DataTables::of($bank)
        ->editColumn('created_at', function ($bank) {
            $created_at = new Carbon($bank->created_at);
            return $created_at->format('d/m/Y à\s H:i:s');
        })
        ->addColumn('action', function ($bank) {
            return '<a class="btn btn-xs btn-default" title="Editar tipo de conta bancaria" onclick="editTypeBank('.$bank->id.')"><i class="fa fa-edit"></i></a>
            <a data-id="'.$bank->id.'" data-toggle="modal" data-target="#modalDeleteTypeAccontBank" class="btn btn-xs btn-danger" title="Excluir tipo de conta bancaria"><i class="fa fa-edit"></i></a>';
        })->make(true);
    }
}

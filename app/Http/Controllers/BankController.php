<?php

namespace Seara\Http\Controllers;

use Seara\Bank;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //PERFIL DE SUPERADMIN
        $this->middleware(['role:superAdmin'])->only(['index', 'show']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bank.index');
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
            $input = ['name' => $request->name];
            Bank::create($input);
            return response()->json(['message' => 'Banco atualizado com sucesso', 'type' => 'success','status' => 200], 200);
            
        }else{
            Bank::where('id', '=', $request->id_bank)->update(['name' => $request->name]);
            return response()->json(['message' => 'Banco cadastrado', 'type' => 'success','status' => 200], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $bank = Bank::findOrFail($id);
            return response()->json($bank);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }

    public function getBank()
    {
        $bank = Bank::all();
        return DataTables::of($bank)
        ->addColumn('action', function ($bank) {
            return '<a href="#edit-'.$bank->id.'" class="btn btn-xs btn-default" title="Editar Banco" onclick="editBank('.$bank->id.')"><i class="fa fa-edit"></i></a>
            <a data-id="'.$bank->id.'" data-toggle="modal" data-target="#modalDeleteBank" class="btn btn-xs btn-danger" title="Excluir Banco"><i class="fa fa-edit"></i></a>';
        })->make(true);
    }
}

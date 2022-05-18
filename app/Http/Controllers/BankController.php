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
        $this->middleware(['role:superAdmin'])->only('index');

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
        try {
            Bank::updateOrCreate($request->all());
            return response()->json(['message' => 'Banco cadastrado', 'type' => 'success','status' => 200], 200);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
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
            return '<a href="#edit-'.$bank->id.'" class="btn btn-xs btn-default" title="Editar Banco"><i class="fa fa-edit"></i> Edit</a>';
        })->make(true);
    }
}

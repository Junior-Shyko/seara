<?php

namespace Seara\Http\Controllers;

use Seara\Transaction;
use Seara\FinancialEntry;
use Seara\Models\Company;
use Seara\FinancialAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinancialEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idCompany = auth()->user()->company_id ?? 406;
        $company = Company::getCompany($idCompany);
        // Calcular totais
        $totalBanks = FinancialAccount::byCompany($idCompany)
            ->banks()
            ->sum('current_balance');
            
        $totalCash = FinancialAccount::byCompany($idCompany)
            ->cash()
            ->sum('current_balance');
            
        $totalGeneral = $totalBanks + $totalCash;
        
        return view('entry.index', compact('totalBanks', 'totalCash', 'totalGeneral', 'idCompany', 'company'));
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
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * DataTables - Retorna dados em JSON
     */
    public function datatable(Request $request)
    {
        $companyId = auth()->user()->company_id ?? 406;
        
        $query = Transaction::with([
                'entries.account',
                'entries.category',
                'createdBy',
                'fromAccount',
                'toAccount'
            ])
            ->byCompany($companyId);
        
        // Filtro por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filtro por período
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->betweenDates($request->start_date, $request->end_date);
        }
        
        return DataTables::of($query)
            ->addColumn('date', function ($transaction) {
                $firstEntry = $transaction->entries->first();
                return $firstEntry ? $firstEntry->entry_date->format('d/m/Y') : '-';
            })
            ->addColumn('type_badge', function ($transaction) {
                return $transaction->type_formatted;
            })
            ->addColumn('amount_formatted', function ($transaction) {
                return $transaction->amount_formatted;
            })
            ->addColumn('account_info', function ($transaction) {
                if ($transaction->isTransfer()) {
                    return $transaction->transfer_description;
                }
                
                $firstEntry = $transaction->entries->first();
                return $firstEntry && $firstEntry->account 
                    ? $firstEntry->account->name 
                    : '-';
            })
            ->addColumn('user', function ($transaction) {
                return $transaction->createdBy ? $transaction->createdBy->name : '-';
            })
            ->addColumn('actions', function ($transaction) {
                return;
                // return view('financial.entries.partials.actions', compact('transaction'))->render();
            })
            ->rawColumns(['type_badge', 'amount_formatted', 'actions'])
            ->make(true);
    }
}

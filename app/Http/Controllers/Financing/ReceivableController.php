<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Account;
use App\Http\Controllers\Controller;
use App\Service\Financing\IncomeCategory\IncomeCategoryRepository;

class ReceivableController extends Controller
{
    public function index(IncomeCategoryRepository $incomeCategoryRepository)
    {
        return view('financing.receivable.index', [
            'title' => 'Contas a Receber',
            'incomeCategories' => $incomeCategoryRepository->findAll(),
            'accounts' => Account::all(),
        ]);
    }
}

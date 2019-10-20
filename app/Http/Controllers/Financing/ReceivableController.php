<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Http\Controllers\Controller;

class ReceivableController extends Controller
{
    public function index()
    {
        return view('financing.receivable.index', [
            'title' => 'Contas a Receber'
        ]);
    }
}

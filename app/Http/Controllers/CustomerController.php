<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index' , compact('company'));
    }
}
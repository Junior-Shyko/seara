<?php

declare(strict_types=1);

namespace Seara\Http\Controllers;

abstract class AuthenticatedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}

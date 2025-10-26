<?php
namespace Seara\Service\Launch;

use Seara\Entry;
use Seara\Seara\Monetary;
use Illuminate\Http\Request;
use Seara\Models\ReceiptCompany;


class CreateLaunch {

    static public function create($request)
    {
        try {
            $launch = Entry::create($request);
            return $launch;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
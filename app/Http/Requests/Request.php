<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function response(array $errors)
    {
        $errorData = [
            'status' => 'error',
            'message' => array_flatten($errors)
        ];
        return parent::response($errorData);
    }
}

<?php

namespace Seara\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettinsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_open' => 'required|date_format:Y-m-d',
            'date_close' => 'date_format:Y-m-d',
            'id_user_open' => 'required|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date_open.date_format' => 'A data de abertura é obrigatória e data válida.',
            'date_close.date_format'  => 'A data do fechamento não é válida',
            'id_user_open.required' => 'Abertura do caixa exige um usuário'
        ];
    }
}

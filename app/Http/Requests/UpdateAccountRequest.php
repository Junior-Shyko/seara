<?php

namespace Seara\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateAccountRequest extends Request
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
            'name' => 'required',
            'type' => [
                'required',
                Rule::in(['checking_account', 'investment', 'money', 'other'])
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'type' => 'Tipo de conta'
        ];
    }
}

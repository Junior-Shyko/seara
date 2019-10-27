<?php

declare(strict_types=1);

namespace App\Http\Requests;


use App\Service\Core\Transformation\FormatBrDate;
use App\Service\Core\Transformation\FormatMoney;

class UpdateReceivableRequest extends Request
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
            'amount' => 'required|numeric',
            'due_date' => 'required|date_format:Y-m-d',
            'description' => 'required|string',
            'income_category_id' => 'required|string',
            'account_id' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'amount' => 'Valor',
            'due_date' => 'Vencimento',
            'description' => 'Descrição',
            'income_category_id' => 'Categoria',
            'account_id' => 'Conta',
        ];
    }

    protected function prepareForValidation()
    {
        $this->transform([
            'amount' => [new FormatMoney()],
            'due_date' => [new FormatBrDate()],
        ]);
    }
}

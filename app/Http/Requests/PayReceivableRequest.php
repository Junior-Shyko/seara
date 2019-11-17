<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Service\Core\Transformation\FormatBrDate;
use App\Service\Core\Transformation\FormatMoney;

class PayReceivableRequest extends Request
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
            'payment_date' => 'required|date_format:Y-m-d',
            'amount' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'payment_date' => 'Data de pagamento',
            'amount' => 'Valor pago'
        ];
    }

    protected function prepareForValidation()
    {
        $this->transform([
            'payment_date' => [new FormatBrDate()],
            'amount' => [new FormatMoney()],
        ]);
    }
}

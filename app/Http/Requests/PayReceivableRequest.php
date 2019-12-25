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
        $totalAmount = $this->request->get('amount');

        $this->request->remove('remaining_amount');
        return [
            'payment_date' => 'required|date_format:Y-m-d',
            'amount' => "required|numeric|min:0",
            'amount_parts' => "required|numeric|min:0|max:{$totalAmount}"
        ];
    }

    public function attributes()
    {
        return [
            'payment_date' => 'Data de pagamento',
            'amount' => 'Valor pago',
            'amount_parts' => 'Valor de multa/juros + abatimento'
        ];
    }

    protected function prepareForValidation()
    {
        $this->transform([
            'payment_date' => [new FormatBrDate()],
            'amount' => [new FormatMoney()],
            'remaining_amount' => [new FormatMoney()],
            'late_fee_amount' => [new FormatMoney()],
            'debt_relief_amount' => [new FormatMoney()],
            'amount_parts' => []
        ]);

        $lateFeeAmount = $this->request->get('late_fee_amount');
        $debtReliefAmount = $this->request->get('debt_relief_amount');

        $this->request->set('amount_parts', round($lateFeeAmount + $debtReliefAmount, 2));
    }
}

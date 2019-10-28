<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Service\Core\Transformation\FormatBrDate;

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
        ];
    }

    public function attributes()
    {
        return [
            'payment_date' => 'Data de pagamento',
        ];
    }

    protected function prepareForValidation()
    {
        $this->transform([
            'payment_date' => [new FormatBrDate()],
        ]);
    }
}

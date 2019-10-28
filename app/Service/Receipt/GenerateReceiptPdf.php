<?php

declare(strict_types=1);

namespace App\Service\Receipt;

use App\Models\ReceiptCompany;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use PDF;

class GenerateReceiptPdf
{
    /**
     * @var GetReceiptSetting
     */
    private $getReceiptSetting;

    public function __construct(GetReceiptSetting $getReceiptSetting)
    {
        $this->getReceiptSetting = $getReceiptSetting;
    }

    public function execute(int $vias, ReceiptCompany $receipt): Response
    {
        PDF::setOptions([

            'dpi' => 72,
            'defaultPaperSize' => 'a4'

        ]);

        $pdf_name = 'recibo-'.$receipt->receipt_date.'.pdf';

        $company = Auth::user()->company;
        $setting = $this->getReceiptSetting->execute()
            ->toArray();

        $pdf = PDF::loadView('receipt-pdf.vias', compact('vias', 'company', 'receipt', 'setting'));

        ini_set('memory_limit', '-1');

        return $pdf->stream($pdf_name);
    }
}

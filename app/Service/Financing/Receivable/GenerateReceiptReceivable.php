<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Receivable;

use Seara\Models\Company;
use Seara\Models\ReceiptCompany;
use Seara\Service\Receipt\CreateReceipt;
use Seara\Service\Receipt\GenerateReceiptPdf;
use Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class GenerateReceiptReceivable
{
    /**
     * @var CreateReceipt
     */
    private $createReceipt;
    /**
     * @var ReceivableRepository
     */
    private $repository;

    public function __construct(
        CreateReceipt $createReceipt,
        ReceivableRepository $repository
    ) {
        $this->createReceipt = $createReceipt;
        $this->repository = $repository;
    }

    public function execute(string $receivableId): ReceiptCompany
    {
        $receivable = $this->repository->find($receivableId);
        $customerCompany = Company::find($receivable->company_id);
        $userCompany = Auth::user()->company;

        $receiptData = [
            'receipt_id_company' => $userCompany->company_id,
            'receipt_value' => $receivable->amount,
            'receipt_date' => Carbon::now()->format('Y-m-d'),
            'receipt_received_from' => $customerCompany->company_name ?? $customerCompany->company_fantasy,
            'receipt_reference' => $receivable->description . ' ' . 'Vencimento ' . Carbon::parse($receivable->due_date)->format('d/m/Y'),
        ];

        $receipt = $this->createReceipt->execute($receiptData);
        return $receipt;
    }
}

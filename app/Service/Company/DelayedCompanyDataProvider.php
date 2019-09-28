<?php

declare(strict_types=1);

namespace App\Service\Company;

class DelayedCompanyDataProvider implements CompanyDataProvider
{
    /**
     * @var CompanyDataProvider
     */
    private $decorated;

    public function __construct(
        CompanyDataProvider $decorated
    ) {
        $this->decorated = $decorated;
    }

    /**
     * @inheritDoc
     */
    public function getCompanyData(string $cnpj): CompanyData
    {
        sleep(30);
        return $this->decorated->getCompanyData($cnpj);
    }
}
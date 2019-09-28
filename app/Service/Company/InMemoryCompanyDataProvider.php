<?php

declare(strict_types=1);

namespace App\Service\Company;

class InMemoryCompanyDataProvider implements CompanyDataProvider
{
    /**
     * @var CompanyData[]
     */
    private $companies;

    public function __construct(array $companies)
    {
        $this->companies = $companies;
    }

    /**
     * @inheritDoc
     */
    public function getCompanyData(string $cnpj): CompanyData
    {
        if ($company = $this->companies[$cnpj] ?? null) {
            return $company;
        }

        throw new CompanyDataUnavailable("Company with cnpj '{$cnpj}' not found");
    }
}
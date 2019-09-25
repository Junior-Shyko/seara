<?php

declare(strict_types=1);

namespace App\Service\Company;

interface CompanyDataProvider
{
    /**
     * @param string $cnpj
     * @return CompanyData
     * @throws CompanyDataUnavailable
     */
    public function getCompanyData(string $cnpj): CompanyData;
}
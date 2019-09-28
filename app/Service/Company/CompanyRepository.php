<?php

declare(strict_types=1);

namespace App\Service\Company;

interface CompanyRepository
{
    public function save(array $companyData);
}
<?php

declare(strict_types=1);

namespace Seara\Service\Company;

use Seara\Models\Company;

class EloquentCompanyRepository implements CompanyRepository
{
    public function save(array $companyData)
    {
        $company = new Company();
        $company->fill($companyData);
        $company->save();
    }
}
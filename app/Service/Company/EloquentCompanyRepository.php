<?php

declare(strict_types=1);

namespace App\Service\Company;

use App\Models\Company;

class EloquentCompanyRepository implements CompanyRepository
{
    public function save(array $companyData)
    {
        $company = new Company();
        $company->fill($companyData);
        $company->save();
    }
}
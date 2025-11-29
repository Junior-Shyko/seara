<?php

declare(strict_types=1);

namespace Seara\Service\Company;

interface CompanyRepository
{
    public function save(array $companyData);
}
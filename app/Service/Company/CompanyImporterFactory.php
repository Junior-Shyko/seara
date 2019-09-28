<?php

declare(strict_types=1);

namespace App\Service\Company;

use App\Service\Core\Csv\LeagueCsvReader;

class CompanyImporterFactory
{
    /**
     * @var CompanyDataProvider
     */
    private $companyDataProvider;

    public function __construct(CompanyDataProvider $companyDataProvider)
    {
        $this->companyDataProvider = $companyDataProvider;
    }

    public function make(): CompanyImporter
    {
        $companyProvider = $this->companyDataProvider;
        if (env('APP_ENV') != 'testing') {
            $companyProvider = new DelayedCompanyDataProvider($companyProvider);
        }

        return new CompanyImporter(
            new CsvCompanyExtractor(
                new LeagueCsvReader(),
                $companyProvider
            ),
            new EloquentCompanyRepository()
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Service\Company;

class CompanyImporter
{
    /**
     * @var Extractor
     */
    private $extractor;
    /**
     * @var CompanyRepository
     */
    private $repository;

    public function __construct(
        Extractor $extractor,
        CompanyRepository $repository
    ) {
        $this->extractor = $extractor;
        $this->repository = $repository;
    }

    public function import(string $path)
    {
        $companies = $this->extractor->extract($path);
        foreach ($companies as $company) {
            $this->repository->save($company);
        }
    }
}
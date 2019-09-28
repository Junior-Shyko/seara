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
    /**
     * @var callable
     */
    private $listener;

    public function __construct(
        Extractor $extractor,
        CompanyRepository $repository
    ) {
        $this->extractor = $extractor;
        $this->repository = $repository;
        $this->listener = function () {};
    }

    public function import(string $path)
    {
        $companies = $this->extractor->extract($path);
        foreach ($companies as $company) {
            $this->repository->save($company);
            ($this->listener)($company);
        }
    }

    /**
     * Sets an optional callback to be executed after every time a company is saved.
     *
     * The callback receives the company data as single argument.
     *
     * @param callable $listener
     */
    public function setListener(callable $listener)
    {
        $this->listener = $listener;
    }
}
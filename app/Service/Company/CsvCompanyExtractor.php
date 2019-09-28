<?php

declare(strict_types=1);

namespace App\Service\Company;

use App\Service\Core\Csv\CsvReader;
use \Iterator;

class CsvCompanyExtractor implements Extractor
{
    /**
     * @var CsvReader
     */
    private $csvReader;
    /**
     * @var CompanyDataProvider
     */
    private $companyDataProvider;

    public function __construct(
        CsvReader $csvReader,
        CompanyDataProvider $companyDataProvider
    ) {
        $this->csvReader = $csvReader;
        $this->companyDataProvider = $companyDataProvider;
    }

    public function extract(string $filePath): Iterator
    {
        $records = $this->csvReader->readFromPath($filePath);
        foreach ($records as $record) {
            $cnpj = $this->getCnpj($record);
            if ($company = $this->getCompany($cnpj)) {
                yield $this->mapCompany($company, $cnpj, $record['responsavel'], $record['tipo']);
            }
        }
    }

    private function getCompany(string $cnpj): ?CompanyData
    {
        try {
            $company = $this->companyDataProvider->getCompanyData($cnpj);
            return $company;
        } catch (CompanyDataUnavailable $exception) {
            return null;
        }
    }

    private function mapCompany(
        CompanyData $company,
        string $cnpj,
        string $manager,
        string $type
    ): array {
        return [
            'company_name' => $company->nome,
            'company_fantasy' => $company->fantasia,
            'company_cnpj' => $cnpj,
            'company_addr_street' => $company->logradouro,
            'company_addr_complement' => $company->complemento,
            'company_addr_number' => $company->numero,
            'company_addr_district' => $company->bairro,
            'company_addr_city' => $company->municipio,
            'company_addr_state' => $company->uf,
            'company_addr_cep' => $company->cep,
            'company_phone' => $company->telefone,
            'company_mobile' => '',
            'company_brand_logo' => '',
            'company_status' => 1,
            'company_manager' => $manager,
            'company_type' => $type
        ];
    }

    private function getCnpj(array $record): string
    {
        $cnpj = preg_replace('/[^\d]/', '', $record['cnpj']);
        return $cnpj;
    }
}
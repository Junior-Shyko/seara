<?php

declare(strict_types=1);

namespace App\Service\Company;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

final class ReceitaWsCompanyDataProvider implements CompanyDataProvider
{
    private const RECEITAWS_API = 'http://receitaws.com.br/v1/';
    private const STATUS_ERROR = 'ERROR';

    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::RECEITAWS_API
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getCompanyData(string $cnpj): CompanyData
    {
        $companyData = $this->makeRequest($cnpj);
        $this->validateCompanyData($companyData);
        return new CompanyData($companyData);
    }

    private function makeRequest(string $cnpj): array
    {
        try {
            $response = $this->client->get("cnpj/{$cnpj}");
            $companyData = json_decode((string) $response->getBody(), true);
            return $companyData;
        } catch (BadResponseException $exception) {
            throw new CompanyDataUnavailable($exception->getMessage());
        }
    }

    private function validateCompanyData(array $companyData)
    {
        if (self::STATUS_ERROR === $companyData['status'] ?? 'OK') {
            throw new CompanyDataUnavailable($companyData['message'] ?? '');
        }
    }
}
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Service\Company\CompanyData;
use App\Service\Company\CompanyDataProvider;
use App\Service\Company\CompanyDataUnavailable;
use App\Service\Company\InMemoryCompanyDataProvider;
use DB;
use Tests\TestCase;

class ImportCustomerTest extends TestCase
{
    /**
     * @var FakeDataProvider
     */
    private $dataProvider;

    protected function setUp()
    {
        parent::setUp();
        $this->dataProvider = new FakeDataProvider([
            '04782450000134' => $this->getJsonData('04782450000134'),
            '21828426000108' => $this->getJsonData('21828426000108')
        ]);
        $this->app->bind(CompanyDataProvider::class, function () {
            return $this->dataProvider;
        });
        $this->artisan('migrate');
        $this->artisan('config:clear');
    }

    protected function tearDown()
    {
        DB::table('companies')->delete();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_imports_customer_data_from_csv_file()
    {
        $path = realpath(__DIR__ . '/customerdata.csv');
        $this->artisan('seara:customer:import', ['file' => $path]);

        $this->assertDatabaseHas(
            'companies',
            $this->dataProvider->formatCompany('04782450000134', 'ABRAAO - CLP', 'igreja')
        );

        $this->assertDatabaseHas(
            'companies',
            $this->dataProvider->formatCompany('21828426000108', 'ADJOVANIO', 'igreja')
        );

        $this->assertDatabaseMissing(
            'companies',
            ['company_cnpj' => '01884892000101']
        );
    }

    private function getJsonData(string $cnpj): CompanyData
    {
        $path = __DIR__ . '/' . $cnpj . '.json';
        $data = json_decode(
            file_get_contents($path),
            true
        );
        return new CompanyData($data);
    }
}

class FakeDataProvider extends InMemoryCompanyDataProvider {
    public function formatCompany(string $cnpj, string $manager, string $type): array
    {
        $company = $this->getCompanyData($cnpj);
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
}
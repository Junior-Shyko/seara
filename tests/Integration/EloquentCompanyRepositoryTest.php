<?php

declare(strict_types=1);

namespace Tests\Integration;

use Seara\Service\Company\EloquentCompanyRepository;
use Seara\Service\Core\Util\DatabaseCleaner;
use Tests\TestCase;

class EloquentCompanyRepositoryTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        DatabaseCleaner::cleanDatabase();
    }

    /**
     * @test
     */
    public function it_saves_the_company()
    {
        $companyData = [
            'company_name' => "Acme",
            'company_fantasy' => 'Acme corporation',
            'company_cnpj' => '12345678912345',
            'company_addr_street' => 'Av G',
            'company_addr_number' => '42',
            'company_addr_complement' => 'B',
            'company_addr_district' => 'José Walter',
            'company_addr_state' => 'Ceará',
            'company_phone' => '16981428018',
            'company_mobile' => '',
            'company_brand_logo' => '',
            'company_status' => 1,
            'company_manager' => 'Fulano de tal',
        ];
        $repository = new EloquentCompanyRepository();
        $repository->save($companyData);

        $this->assertDatabaseHas('companies', $companyData);
    }
}

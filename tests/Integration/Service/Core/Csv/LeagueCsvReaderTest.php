<?php

declare(strict_types=1);

namespace Tests\Integration\Service\Core\Csv;

use App\Service\Core\Csv\LeagueCsvReader;
use PHPUnit\Framework\TestCase;

class LeagueCsvReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_parses_csv_records_into_an_associative_array()
    {
        $filePath = __DIR__ . '/customerdata.csv';
        $reader = new LeagueCsvReader();
        $records = array_values(iterator_to_array($reader->readFromPath($filePath)));

        $this->assertEquals([
            ['cnpj' => '04.782.450/0001-34', 'responsavel' => 'ABRAAO - CLP', 'tipo' => 'igreja'],
            ['cnpj' => '01.884.892/0001-01', 'responsavel' => 'AIRTON', 'tipo' => 'igreja']
        ], $records);
    }
}
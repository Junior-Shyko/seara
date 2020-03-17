<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Report\DebtReport;

use App\Service\Report\DebtReport\DebtReportResult;
use App\Service\Report\DebtReport\DebtReportResultSet;
use App\Service\Report\DebtReport\ResultSetToRowsConverter;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ResultSetToRowsConverterTest extends TestCase
{
    /**
     * @test
     */
    public function shouldMapAResultSetToTheReportRows()
    {
        $converter = new ResultSetToRowsConverter();

        $resultSet = new DebtReportResultSet(
            'Megadodo publications',
            'Ford Prefect',
            [
                new DebtReportResult(
                    Carbon::create(2019, 10, 10),
                    'Mensalidade',
                    -210.50
                ),
                new DebtReportResult(
                    Carbon::create(2019, 11, 10),
                    'Mensalidade',
                    -210.50
                ),
                new DebtReportResult(
                    Carbon::create(2019, 12, 10),
                    'Mensalidade',
                    -210.50
                ),
                new DebtReportResult(
                    Carbon::create(2019, 12, 23),
                    'Pagamento',
                    1623.48
                ),
                new DebtReportResult(
                    Carbon::create(2020, 01, 10),
                    'Mensalidade',
                    -210.50
                ),
                new DebtReportResult(
                    Carbon::create(2020, 02, 10),
                    'Mensalidade',
                    -220.80
                ),
            ]
        );

        $expectedRows = [

            ['09', '2019', '10/10/2019', 'Mensalidade',  210.50,     null, '=E4-F4'],
            ['10', '2019', '10/11/2019', 'Mensalidade',  210.50,     null, '=G4+E5-F5'],
            ['11', '2019', '10/12/2019', 'Mensalidade',  210.50,     null, '=G5+E6-F6'],
            [null,   null, '23/12/2019',   'Pagamento',      null, 1623.48, '=G6+E7-F7'],
            ['12', '2019', '10/01/2020', 'Mensalidade',  210.50,     null, '=G7+E8-F8'],
            ['01', '2020', '10/02/2020', 'Mensalidade',  220.80,     null, '=G8+E9-F9'],

            [null, null, null, null, '=SUM(E4:E9)', '=SUM(F4:F9)', '=E10-F10'],
        ];

        $this->assertEquals($expectedRows, $converter->convert($resultSet, 4));
    }
}

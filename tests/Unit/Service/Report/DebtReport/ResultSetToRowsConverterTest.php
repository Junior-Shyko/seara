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
                    623.48
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

            ['09', '2019', '10/10/2019', 'Mensalidade',  '210.50',     null, '=INDIRECT("RC[-2]", 0)'],
            ['10', '2019', '10/11/2019', 'Mensalidade',  '210.50',     null, '=INDIRECT("R[-1]C", 0) + INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)'],
            ['11', '2019', '10/12/2019', 'Mensalidade',  '210.50',     null, '=INDIRECT("R[-1]C", 0) + INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)'],
            [null,   null, '23/12/2019',   'Pagamento',      null, '623.48', '=INDIRECT("R[-1]C", 0) + INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)'],
            ['12', '2019', '10/01/2020', 'Mensalidade',  '210.50',     null, '=INDIRECT("R[-1]C", 0) + INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)'],
            ['01', '2020', '10/02/2020', 'Mensalidade',  '220.80',     null, '=INDIRECT("R[-1]C", 0) + INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)'],

            [null, null, null, null, '=SUM(E4:INDIRECT("R[-1]C", 0))', '=SUM(F4:INDIRECT("R[-1]C", 0))', '=INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)'],
        ];

        $this->assertEquals($expectedRows, $converter->convert($resultSet));
    }
}

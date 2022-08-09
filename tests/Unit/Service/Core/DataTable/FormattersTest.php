<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Core\DataTable;

use Seara\Service\Core\DataTable\Formatters\Format;
use PHPUnit\Framework\TestCase;
use stdClass;

class FormattersTest extends TestCase
{
    /**
     * @test
     */
    public function it_parses_floats_into_money_format()
    {
        $formatter = Format::asCurrency();

        $row = new stdClass();
        $row->amount = 1987.95;

        $formattedMoney = $formatter->format($row->amount, $row);

        $this->assertSame('1.987,95', $formattedMoney);
    }

    /**
     * @test
     */
    public function it_formats_dates()
    {
        $formatter = Format::asDate();

        $row = new stdClass();
        $row->date = '1994-09-21';

        $formattedDate = $formatter->format($row->date, $row);

        $this->assertSame('21/09/1994', $formattedDate);
    }

    /**
     * @test
     */
    public function it_formats_dates_using_fallback_source_formats()
    {
        $formatter = Format::asDate();

        $row = new stdClass();
        $row->date = '1994-09-21 01:00:00';

        $formattedDate = $formatter->format($row->date, $row);

        $this->assertSame('21/09/1994', $formattedDate);
    }
}

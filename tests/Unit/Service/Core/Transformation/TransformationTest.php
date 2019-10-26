<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Core\Transformation;

use App\Service\Core\Transformation\FormatBrDate;
use App\Service\Core\Transformation\FormatMoney;
use PHPUnit\Framework\TestCase;

class TransformationTest extends TestCase
{
    /**
     * @test
     */
    public function it_converts_money_format_to_float()
    {
        $input = '3.457,23';
        $this->assertSame(3457.23, $this->call(FormatMoney::class, $input));
    }

    /**
     * @test
     */
    public function it_ignores_invalid_dates()
    {
        $input = '20/15/2019';
        $this->assertSame($input, $this->call(FormatBrDate::class, $input));
    }

    /**
     * @test
     */
    public function it_formats_br_date_to_usa_format()
    {
        $input = '20/05/2019';
        $this->assertSame('2019-05-20', $this->call(FormatBrDate::class, $input));
    }

    private function call(string $class, $input)
    {
        $transformation = new $class;
        return $transformation($input);
    }
}

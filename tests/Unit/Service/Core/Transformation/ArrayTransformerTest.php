<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Core\Transformation;

use App\Service\Core\Transformation\FormatBrDate;
use App\Service\Core\Transformation\FormatMoney;
use PHPUnit\Framework\TestCase;

use App\Service\Core\Transformation\ArrayTransformer;

class ArrayTransformerTest extends TestCase
{
    /**
     * @var ArrayTransformer
     */
    private $transformer;

    protected function setUp()
    {
        $this->transformer = new ArrayTransformer();
    }

    /**
     * @test
     */
    public function it_transforms_the_existing_keys()
    {
        $input = [
            'foo' => '26/05/2020',
            'bar' => '6.880,42',
            'baz' => 42,
            'foobar' => 'aff',
        ];

        $transformations = [
            'foo' => [
                new FormatBrDate()
            ],
            'bar' => [
                new FormatMoney()
            ],
            'baz' => function ($input) {
                return $input * 2;
            }
        ];

        $this->assertSame([
            'foo' => '2020-05-26',
            'bar' => 6880.42,
            'baz' => 84,
            'foobar' => 'aff',
        ], $this->transformer->transform($input, $transformations));
    }
}

<?php

declare(strict_types=1);

namespace Tests\Integration\Service\Core\Transactor;

use App\Service\Core\Transactor\EloquentTransactor;
use App\Service\Support\DatabaseHelper;
use DB;
use Tests\TestCase;
use Throwable;
use TypeError;
use Exception;

class EloquentTransactorTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        DatabaseHelper::cleanDatabase();;
    }

    /**
     * @test
     */
    public function it_rolls_back_transaction_when_an_exception_is_thrown()
    {
        $transactor = new EloquentTransactor();
        try {
            $transactor->perform(function () {
                DB::table('income_category')->insert([
                    'id' => 'uuid',
                    'name' => 'Contratos'
                ]);
                throw new TypeError('Some random type error');
            });
        } catch (Throwable $e) {
        }

        $count = DB::table('income_category')->get()->count();
        $this->assertEquals(0, $count);
    }

    /**
     * @test
     */
    public function it_rethrows_the_exception()
    {
        $exception = new Exception('Random exception');
        $transactor = new EloquentTransactor();
        try {
            $transactor->perform(function () use ($exception) {
                throw $exception;
            });
        } catch (Throwable $e) {
            $this->assertSame($exception, $e);
        }
    }
}

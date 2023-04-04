<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Financing\Receivable;

use Seara\Receivable;
use Seara\Service\Financing\Receivable\CreateReceivable;
use Seara\Service\Financing\Receivable\ReceivableNotFound;
use Seara\Service\Financing\Receivable\ReceivableRepository;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class CreateReceivableTest extends TestCase implements ReceivableRepository
{
    private const CATEGORY_ID = 'some_category_uuid';
    private const ACCOUNT_ID = 'some_account_uuid';
    private const COMPANY_ID = 'some_company_id';

    private $receivables;

    protected function setUp()
    {
        $this->receivables = [];
    }

    /**
     * @test
     */
    public function it_saves_a_single_receivable()
    {
        $receivableId = 'custom_uuid';

        $dueDate = Carbon::createFromFormat('!Y-m-d', '2042-10-05');
        $receivableData = [
            'amount' => 420.45,
            'due_date' => $dueDate->format('Y-m-d'),
            'description' => 'Salário',
            'income_category_id' => self::CATEGORY_ID,
            'account_id' => self::ACCOUNT_ID,
            'company_id' => self::COMPANY_ID
        ];

        $expectedReceivable = [
            'id' => $receivableId,
            'amount' => 420.45,
            'due_date' => $dueDate->format('Y-m-d'),
            'description' => 'Salário',
            'income_category_id' => self::CATEGORY_ID,
            'account_id' => self::ACCOUNT_ID,
            'company_id' => self::COMPANY_ID
        ];

        $repository = $this->prophesize(ReceivableRepository::class);
        $repository
            ->save($expectedReceivable)
            ->shouldBeCalled();
        $repository
            ->nextIdentity()
            ->willReturn($receivableId);

        $createReceivable = new CreateReceivable($repository->reveal());
        $createReceivable->execute($receivableData);
    }

    /**
     * @test
     * @dataProvider provideSequenceData
     * @param $count
     * @param $dueDate
     * @param $allDueDates
     */
    public function it_generates_a_sequence_of_receivables($count, $dueDate, $allDueDates)
    {
        $receivableData = [
            'amount' => 420.45,
            'due_date' => $dueDate,
            'description' => 'Salário',
            'income_category_id' => self::CATEGORY_ID,
            'account_id' => self::ACCOUNT_ID,
            'company_id' => self::COMPANY_ID,
            'repeat_for' => $count
        ];

        $createReceivable = new CreateReceivable($this);
        $createReceivable->execute($receivableData);

        $this->assertSavedSequenceWithDueDates($receivableData, $allDueDates);
    }

    public function provideSequenceData()
    {
        return [
            [3, '2019-05-20', ['2019-05-20', '2019-06-20', '2019-07-20']],
            [2, '2019-05-31', ['2019-05-31', '2019-06-30']],
            [2, '2019-01-31', ['2019-01-31', '2019-02-28']],
            [2, '2020-01-31', ['2020-01-31', '2020-02-29']],
        ];
    }

    /**
     * @inheritDoc
     */
    public function save(array $receivable): void
    {
        $this->receivables[] = $receivable;
    }

    public function nextIdentity(): string
    {
        return 'customuuid';
    }

    public function find(string $id): Receivable
    {
        throw ReceivableNotFound::withId($id);
    }

    public function update(string $id, array $receivable): void
    {
    }

    private function assertSavedSequenceWithDueDates(array $receivable, $allDueDates)
    {
        $sequenceId = array_pluck($this->receivables, 'sequence_id')[0];
        $count = count($allDueDates);

        $expectedSequences = [];
        foreach ($allDueDates as $idx => $dueDate) {
            $expectedSequences[] = [
                'sequence_id' => $sequenceId,
                'sequence_number' => $idx + 1,
                'sequence_count' => $count,
                'due_date' => $dueDate,
                'amount' => $receivable['amount'],
                'description' => $receivable['description'],
                'income_category_id' => $receivable['income_category_id'],
                'account_id' => $receivable['account_id'],
                'company_id' => $receivable['company_id']
            ];
        }

        $savedSequences = array_map(function ($receivable) {
            return array_except($receivable, 'id');
        }, $this->receivables);

        $this->assertCount($count, $savedSequences);
        $this->assertEquals($expectedSequences, $savedSequences);
    }
}

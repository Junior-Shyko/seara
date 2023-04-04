<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Financing\Receivable;

use Seara\Receivable;
use Seara\Service\Core\Util\UuidGenerator;
use Seara\Service\Financing\Payment\CreatePayment;
use Seara\Service\Financing\Receivable\CreateReceivable;
use Seara\Service\Financing\Receivable\PayReceivable;
use Seara\Service\Financing\Receivable\PendingReceivable\PendingReceivable;
use Seara\Service\Financing\Receivable\PendingReceivable\PendingReceivableQuery;
use Seara\Service\Financing\Receivable\ReceivableRepository;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PayReceivableTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_single_part_when_the_amount_matches_the_receivable_amount()
    {
        $receivableId = UuidGenerator::generate();

        $paymentData = [
            'amount' => 42.42,
            'payment_date' => '2019-01-01',
            'receivable_id' => $receivableId,
        ];

        $createPayment = $this->prophesize(CreatePayment::class);
        $createPayment
            ->execute([
                'amount' => 42.42,
                'payment_date' => '2019-01-01'
            ], [
                [
                    'receivable_id' => $receivableId,
                    'amount' => 42.42,
                ]
            ])
            ->shouldBeCalled();

        $receivable = (new Receivable())
            ->fill([
                'id' => $receivableId,
                'amount' => 42.42,
                'due_date' => Carbon::create(2018, 10, 01)
            ]);

        $receivableRepository = $this->prophesize(ReceivableRepository::class);
        $receivableRepository
            ->find($receivableId)
            ->willReturn($receivable);

        $pendingReceivableQuery = $this->prophesize(PendingReceivableQuery::class);
        $pendingReceivableQuery
            ->nextPendingReceivables($receivable)
            ->willReturn([
                new PendingReceivable($receivableId, 42.42)
            ]);

        $payReceivable = new PayReceivable(
            $createPayment->reveal(),
            $receivableRepository->reveal(),
            $pendingReceivableQuery->reveal()
        );

        $payReceivable->execute($paymentData);
    }

    /**
     * @test
     */
    public function it_generates_a_part_for_each_of_the_next_pending_receivables()
    {
        $receivableId = UuidGenerator::generate();

        $receivable = (new Receivable())
            ->fill([
                'id' => $receivableId,
                'amount' => 42,
                'due_date' => Carbon::create(2018, 10, 01)
            ]);

        $paymentData = [
            'amount' => 672,
            'payment_date' => '2019-01-01',
            'receivable_id' => $receivableId,
        ];

        /** @var PendingReceivable[] $pendingReceivables */
        $pendingReceivables = [
            new PendingReceivable($receivableId, 42),
            new PendingReceivable(UuidGenerator::generate(), 120),
            new PendingReceivable(UuidGenerator::generate(), 210),
            new PendingReceivable(UuidGenerator::generate(), 500),
            new PendingReceivable(UuidGenerator::generate(), 220)
        ];

        $receivableRepository = $this->prophesize(ReceivableRepository::class);
        $receivableRepository
            ->find($receivableId)
            ->willReturn($receivable);

        $pendingReceivableQuery = $this->prophesize(PendingReceivableQuery::class);
        $pendingReceivableQuery
            ->nextPendingReceivables($receivable)
            ->willReturn($pendingReceivables);

        $createPayment = $this->prophesize(CreatePayment::class);
        $createPayment
            ->execute([
                'amount' => $paymentData['amount'],
                'payment_date' => $paymentData['payment_date'],
            ], [
                [
                    'receivable_id' => $pendingReceivables[0]->getReceivableId(),
                    'amount' => $pendingReceivables[0]->getPendingAmount(),
                ],
                [
                    'receivable_id' => $pendingReceivables[1]->getReceivableId(),
                    'amount' => $pendingReceivables[1]->getPendingAmount(),
                ],
                [
                    'receivable_id' => $pendingReceivables[2]->getReceivableId(),
                    'amount' => $pendingReceivables[2]->getPendingAmount(),
                ],
                [
                    'receivable_id' => $pendingReceivables[3]->getReceivableId(),
                    'amount' => 300,
                ],
            ])
            ->shouldBeCalled();

        $payReceivable = new PayReceivable(
            $createPayment->reveal(),
            $receivableRepository->reveal(),
            $pendingReceivableQuery->reveal()
        );

        $payReceivable->execute($paymentData);
    }

    /**
     * @test
     */
    public function it_generates_a_receivable_and_the_corresponding_part_when_it_has_a_late_fee_amount()
    {
        $receivableId = UuidGenerator::generate();
        $lateFeeReceivableId = UuidGenerator::generate();

        $receivable = (new Receivable())
            ->fill([
                'id' => $receivableId,
                'amount' => 42,
                'due_date' => Carbon::create(2018, 10, 01),
                'income_category_id' => 'category_id',
                'account_id' => 'account_id',
                'company_id' => 4254
            ]);

        $lateFeeReceivableData = [
            'id' => $lateFeeReceivableId,
            'amount' => 10.50,
            'due_date' => $receivable->due_date,
            'description' => 'Juros/multa',
            'income_category_id' => $receivable->income_category_id,
            'account_id' => $receivable->account_id,
            'company_id' => $receivable->company_id
        ];

        $paymentData = [
            'amount' => 682.50,
            'payment_date' => '2019-01-01',
            'receivable_id' => $receivableId,
            'late_fee_amount' => 10.50,
        ];

        /** @var PendingReceivable[] $pendingReceivables */
        $pendingReceivables = [
            new PendingReceivable($receivableId, 42),
            new PendingReceivable(UuidGenerator::generate(), 120),
            new PendingReceivable(UuidGenerator::generate(), 210),
            new PendingReceivable(UuidGenerator::generate(), 500),
            new PendingReceivable(UuidGenerator::generate(), 220)
        ];

        $receivableRepository = $this->prophesize(ReceivableRepository::class);
        $receivableRepository
            ->find($receivableId)
            ->willReturn($receivable);

        $receivableRepository
            ->nextIdentity()
            ->willReturn($lateFeeReceivableId);

        $receivableRepository
            ->save($lateFeeReceivableData)
            ->shouldBeCalled();

        $pendingReceivableQuery = $this->prophesize(PendingReceivableQuery::class);
        $pendingReceivableQuery
            ->nextPendingReceivables($receivable)
            ->willReturn($pendingReceivables);


        $createPayment = $this->prophesize(CreatePayment::class);
        $createPayment
            ->execute([
                'amount' => $paymentData['amount'],
                'payment_date' => $paymentData['payment_date'],
            ], [
                [
                    'receivable_id' => $lateFeeReceivableId,
                    'amount' => 10.50,
                ],
                [
                    'receivable_id' => $pendingReceivables[0]->getReceivableId(),
                    'amount' => $pendingReceivables[0]->getPendingAmount(),
                ],
                [
                    'receivable_id' => $pendingReceivables[1]->getReceivableId(),
                    'amount' => $pendingReceivables[1]->getPendingAmount(),
                ],
                [
                    'receivable_id' => $pendingReceivables[2]->getReceivableId(),
                    'amount' => $pendingReceivables[2]->getPendingAmount(),
                ],
                [
                    'receivable_id' => $pendingReceivables[3]->getReceivableId(),
                    'amount' => 300,
                ],
            ])
            ->shouldBeCalled();

        $payReceivable = new PayReceivable(
            $createPayment->reveal(),
            $receivableRepository->reveal(),
            $pendingReceivableQuery->reveal()
        );

        $payReceivable->execute($paymentData);
    }
}

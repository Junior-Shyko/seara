<?php

declare(strict_types=1);

namespace Seara;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property  int $id
 * @property string $payment_id
 * @property float $amount
 * @property DateTime $payment_date
 * @property string $receivable_id
 */
class PaymentPart extends Model
{
    protected $table = 'payment_part';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'payment_id',
        'amount',
        'payment_date',
        'receivable_id',
    ];
}

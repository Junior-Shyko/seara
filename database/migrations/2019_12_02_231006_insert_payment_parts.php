<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPaymentParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $paymentParts = DB::table('payment')
            ->get()
            ->map(function ($payment) {
                return [
                    'payment_id' => $payment->id,
                    'amount' => $payment->amount,
                    'payment_date' => $payment->payment_date,
                    'receivable_id' => $payment->receivable_id,
                ];
            })
            ->toArray();

        DB::table('payment_part')->insert($paymentParts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('delete from payment_part;');
    }
}

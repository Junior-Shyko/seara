<?php

use App\Service\Core\Util\UuidGenerator;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;

class InsertPaymentsFromReceivable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $payments = DB::table('receivable')
            ->whereNotNull('payment_date')
            ->get()
            ->map(function ($receivable) {
                return [
                    'id' => UuidGenerator::generate(),
                    'amount' => $receivable->amount,
                    'receivable_id' => $receivable->id,
                    'payment_date' => $receivable->payment_date,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })
            ->toArray();

        DB::table('payment')->insert($payments);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('delete from payment;');
    }
}

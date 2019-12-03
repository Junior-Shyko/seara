<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentPartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_part', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('payment_id');
            $table->float('amount');
            $table->date('payment_date');
            $table->uuid('receivable_id');

            $table->foreign('payment_id')
                ->references('id')
                ->on('payment')
                ->onDelete('cascade');

            $table->foreign('receivable_id')
                ->references('id')
                ->on('receivable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_part');
    }
}

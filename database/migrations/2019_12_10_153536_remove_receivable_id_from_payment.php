<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveReceivableIdFromPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropForeign(['receivable_id']);
            $table->dropColumn('receivable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->uuid('receivable_id')->after('payment_date')->nullable();

            $table->foreign('receivable_id')
                ->references('id')
                ->on('receivable');
        });
    }
}

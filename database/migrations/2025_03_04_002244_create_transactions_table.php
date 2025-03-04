<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transactions');
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_company')->unsigned();
            $table->integer('id_type_account');
            $table->integer('from_account_id')->unsigned();
            $table->integer('to_account_id')->unsigned();
            $table->float('amount', 8,2);
            $table->string('description', 256);
            $table->foreign('id_company')->references('company_id')->on('companies')->onDelete('cascade');
            $table->foreign('from_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('to_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

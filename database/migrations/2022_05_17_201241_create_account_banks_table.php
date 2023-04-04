<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_id')->unsigned();
            $table->integer('typeBank_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('number', 50);
            $table->string('agency_number', 50);
            $table->float('balance', 8, 2);
            $table->integer('owner');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('typeBank_id')->references('id')->on('type_banks');
            $table->foreign('company_id')->references('company_id')->on('companies');
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
        Schema::dropIfExists('account_banks');
    }
}

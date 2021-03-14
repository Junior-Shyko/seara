<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('entries_id');
            $table->integer('entries_id_account');
            $table->integer('entries_id_box');
            $table->char('entries_day', 3);
            $table->string('entries_description', 255);
            $table->float('entries_balance_initial', 8,2);
            $table->float('entries_balance_previous', 8,2);
            $table->float('entries_decimate', 8,2);
            $table->float('entries_offer', 8,2);
            $table->float('entries_end', 8,2);
            $table->float('entries_balance', 8,2);
            $table->float('entries_balance_end', 8,2);
            $table->float('entries_other', 8,2);
            $table->timestamps();

            $table->integer('entries_id_company')->unsigned()->nullable();
			$table->foreign('entries_id_company')->references('company_id')->on('companies');
            $table->integer('entries_id_user')->unsigned()->nullable();
			$table->foreign('entries_id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entries');
    }
}

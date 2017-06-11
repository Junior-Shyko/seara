<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignBoxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->integer('boxes_id_account')->unsigned()->nullable();
            $table->foreign('boxes_id_account')->references('accounts_id')->on('accounts');

            $table->integer('boxes_id_user')->unsigned()->nullable();
            $table->foreign('boxes_id_user')->references('id')->on('users');

            $table->integer('boxes_id_company')->unsigned()->nullable();
            $table->foreign('boxes_id_company')->references('company_id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boxes', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->float('balance_bank', 8, 2);
            $table->float('balance_internal', 8, 2);
            $table->float('balance_general', 8, 2);
            $table->integer('company_id')->unsigned();
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
        Schema::dropIfExists('settings_entries');
    }
}

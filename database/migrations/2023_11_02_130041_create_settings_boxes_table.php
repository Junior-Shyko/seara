<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('settings_boxes', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->dateTime('date_open')->nullable(false);
        //     $table->dateTime('date_close')->nullable(true);
        //     $table->string('month', 50)->nulable(false);
        //     $table->string('year', 50)->nulable(false);
        //     $table->integer('id_user_open')->nulable(false);
        //     $table->integer('id_user_close')->nulable(true);
        //     $table->integer('id_company')->unsigned();
        //     $table->string('slug', 25)->nulable(true);
        //     $table->foreign('id_company')->references('company_id')->on('companies');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_boxes');
    }
}

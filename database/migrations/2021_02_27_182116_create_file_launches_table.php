<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileLaunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_launches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_launches_name');
            $table->integer('file_launches_id_entry')->unsigned()->nullable();
            $table->foreign('file_launches_id_entry')->references('entries_id')->on('entries');
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
        Schema::dropIfExists('file_launches');
    }
}

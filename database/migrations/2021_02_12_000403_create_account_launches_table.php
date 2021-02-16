<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLaunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_launches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('accountlaunch_name', 150);
            $table->integer('accountlaunch_type');
            $table->integer('accountlaunch_id_user')->unsigned()->nullable();
            $table->string('accountlaunch_history', 256);
            $table->timestamps();
            $table->foreign('accountlaunch_id_user')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_launches');
    }
}

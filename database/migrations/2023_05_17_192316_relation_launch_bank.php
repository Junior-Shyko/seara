<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationLaunchBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_launch_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_parent')->nullable(false);
            $table->integer('account_child')->nullable(false);
            $table->float('value', 8, 2)->nullable(false);
            $table->string('type', 30)->nullable(false);
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
        //
    }
}

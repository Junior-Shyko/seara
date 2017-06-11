<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBoxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->increments('boxes_id');
            $table->string('boxes_description');
            //$table->integer('boxes_id_account');
            //$table->integer('boxes_id_user'); 
            //$table->integer('boxes_id_company');
            $table->float('boxes_balance_initial', 8,2);
            $table->float('boxes_balance_previous', 8,2);
            $table->float('boxes_decimate');
            $table->float('box_offer', 8,2); 
            $table->float('box_end', 8,2); 
            $table->float('box_balance', 8,2); 
            $table->float('box_balance_end', 8,2);
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
        Schema::dropIfExists('boxes');
    }
}

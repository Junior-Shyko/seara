<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_addr_cep' , 10);
            $table->string('user_addr_street' , 100);
            $table->string('user_addr_number' , 10);
            $table->string('user_addr_complement' , 50);
            $table->string('user_addr_district' , 100);
            $table->string('user_addr_city' , 100);
            $table->string('user_addr_state' , 10);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}

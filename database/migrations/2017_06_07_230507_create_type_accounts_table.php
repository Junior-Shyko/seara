<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_accounts', function (Blueprint $table) {
            $table->increments('type_accounts_id');
            $table->integer('type_accounts_name');
            $table->integer('type_accounts_id_user');
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
        Schema::dropIfExists('type_accounts');
    }
}

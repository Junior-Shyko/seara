<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_addr_street' , 150);
            $table->string('company_addr_number' , 10);
            $table->string('company_addr_complement' , 50);
            $table->string('company_addr_district' , 150);
            $table->string('company_addr_city' , 150);
            $table->string('company_addr_state' , 5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
}

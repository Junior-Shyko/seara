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
            $table->string('company_addr_street' , 150)->change();
            $table->string('company_addr_number' , 10)->change();
            $table->string('company_addr_complement' , 50)->change();
            $table->string('company_addr_district' , 150)->change();
            $table->string('company_addr_city' , 150)->change();
            $table->string('company_addr_state' , 5)->change();
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

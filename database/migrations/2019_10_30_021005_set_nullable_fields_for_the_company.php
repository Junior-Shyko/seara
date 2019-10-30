<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableFieldsForTheCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE companies MODIFY company_addr_complement VARCHAR(50) NULL");
        DB::statement("ALTER TABLE companies MODIFY company_mobile VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE companies MODIFY company_addr_complement VARCHAR(50) NOT NULL");
        DB::statement("ALTER TABLE companies MODIFY company_mobile VARCHAR(255) NOT NULL");
    }
}

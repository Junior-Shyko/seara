<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table
                ->enum('company_type', [
                    "igreja",
                    "associacao",
                    "condominio",
                    "lucro_presumido",
                    "simples_nacional",
                    "fundacao",
                    "outro"
                ])
                ->default("outro");
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
            $table->dropColumn(['company_type']);
        });
    }
}

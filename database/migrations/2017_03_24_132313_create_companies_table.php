<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('company_id');         // id
            $table->string('company_name');           // razão social
            $table->string('company_fantasy');        // nome fantasia
            $table->string('company_responsible');    // responsável pela empresa
            $table->string('company_cnpj')->unique(); // cnpj da empresa
            $table->string('company_street');         // logradouro da empresa
            $table->string('company_number');         // numero da empresa
            $table->string('company_complement');     // complemento da empresa
            $table->string('company_district');       // bairro
            $table->string('company_city');           // cidade
            $table->string('company_state');          // estado
            $table->string('company_phone');          // telefone
            $table->string('company_mobile');         // celular
            $table->string('company_brand_logo');     // logo da empresa
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
        Schema::dropIfExists('companies');
    }
}

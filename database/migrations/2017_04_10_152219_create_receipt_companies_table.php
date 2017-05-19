<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('receipt_company', function (Blueprint $table) {
        $table->increments('receipt_id');
        $table->integer('receipt_id_company')->unsigned();
        $table->float('receipt_value', 12, 2);
        $table->string('receipt_extensive_value');
        $table->string('receipt_received_from');
        $table->string('receipt_reference');
        $table->string('receipt_local');
        $table->date('receipt_date');
        $table->string('receipt_emitter');
        $table->string('receipt_document'); //cpf,cnpj,crc
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
        Schema::dropIfExists('receipt_companies');
    }
}

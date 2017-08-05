<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_settings', function (Blueprint $table) {

            // Columns
            $table->increments('setting_id');
            $table->integer('setting_id_company')->unsigned();
            $table->string('setting_receipt_local');
            $table->string('setting_receipt_emitter');
            $table->string('setting_receipt_document');
            $table->string('setting_receipt_email');
            $table->string('setting_receipt_header');
            $table->timestamps();

            // Foreign keys
            $table->foreign('setting_id_company')->references('company_id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_settings');
    }
}

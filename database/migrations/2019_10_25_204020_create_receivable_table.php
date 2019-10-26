<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivable', function (Blueprint $table) {
            $table->uuid('id');
            $table->float('amount');
            $table->date('due_date');
            $table->string('description');
            $table->uuid('income_category_id');
            $table->uuid('account_id');
            $table->unsignedInteger('company_id')->nullable();
            $table->uuid('sequence_id')->nullable();
            $table->integer('sequence_number')->nullable();
            $table->integer('sequence_count')->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('income_category_id')
                ->references('id')
                ->on('income_category');

            $table->foreign('account_id')
                ->references('id')
                ->on('account');

            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies');

            $table->unique(['sequence_id', 'sequence_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receivable');
    }
}

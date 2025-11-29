<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->enum('type', ['bank', 'cash']);
            
            // Campos específicos para bancos
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('agency_number', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            
            // Relacionamentos e controle
            $table->unsignedInteger('company_id');
            $table->decimal('current_balance', 15, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('bank_id')
                  ->references('id')
                  ->on('banks')
                  ->onDelete('set null');
                  
            $table->foreign('company_id')
                  ->references('company_id')
                  ->on('companies')
                  ->onDelete('cascade');
            
            // Indexes
            $table->index(['company_id', 'type']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_accounts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('category_id')->nullable();
            
            $table->enum('type', ['debit', 'credit']);
            $table->string('description', 255);
            $table->decimal('amount', 15, 2);
            $table->date('entry_date');
            $table->string('document_file', 256)->nullable();
            
            // Relacionamentos
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('created_by_user_id');
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('transaction_id')
                  ->references('id')
                  ->on('transactions')
                  ->onDelete('cascade');
                  
            $table->foreign('account_id')
                  ->references('id')
                  ->on('financial_accounts')
                  ->onDelete('restrict');
                  
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');
                  
            $table->foreign('company_id')
                  ->references('company_id')
                  ->on('companies')
                  ->onDelete('cascade');
                  
            $table->foreign('created_by_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
            
            // Indexes
            $table->index(['entry_date', 'account_id']);
            $table->index('transaction_id');
            $table->index('type');
            $table->index(['company_id', 'entry_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_entries');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36)->unique();
            $table->enum('type', ['income', 'expense', 'transfer']);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->string('description', 255);
            $table->decimal('total_amount', 15, 2);
            
            // Campos específicos para transferências
            $table->unsignedInteger('from_account_id')->nullable();
            $table->unsignedInteger('to_account_id')->nullable();
            
            // Relacionamentos
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('created_by_user_id');
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('from_account_id')
                  ->references('id')
                  ->on('financial_accounts')
                  ->onDelete('set null');
                  
            $table->foreign('to_account_id')
                  ->references('id')
                  ->on('financial_accounts')
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
            $table->index('uuid');
            $table->index(['company_id', 'created_at']);
            $table->index(['type', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'type', 'status', 'description', 'total_amount', 
            'from_account_id', 'to_account_id', 'company_id', 'created_by_user_id', 
            'created_at', 'updated_at' ]);
        });
    }
}

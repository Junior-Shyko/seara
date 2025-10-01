<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->increments('id');
            $table->char('transfer_group_id', 36)->unique();
            
            $table->unsignedInteger('from_account_id');
            $table->unsignedInteger('to_account_id');
            $table->decimal('amount', 15, 2);
            
            $table->unsignedInteger('debit_entry_id');
            $table->unsignedInteger('credit_entry_id');
            
            $table->date('transfer_date');
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('from_account_id')
                  ->references('id')
                  ->on('financial_accounts')
                  ->onDelete('restrict');
                  
            $table->foreign('to_account_id')
                  ->references('id')
                  ->on('financial_accounts')
                  ->onDelete('restrict');
                  
            $table->foreign('debit_entry_id')
                  ->references('id')
                  ->on('financial_entries')
                  ->onDelete('cascade');
                  
            $table->foreign('credit_entry_id')
                  ->references('id')
                  ->on('financial_entries')
                  ->onDelete('cascade');
            
            // Indexes
            $table->index('transfer_group_id');
            $table->index(['from_account_id', 'to_account_id']);
            $table->index('transfer_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_details');
    }
}

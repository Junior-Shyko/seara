<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
            Schema::create('entries', function (Blueprint $table) {
            $table->increments('entries_id');
            $table->string('entries_description');
            //$table->float('entries_balance_initial', 8,2);
            //$table->float('entries_balance_previous', 8,2);
            $table->float('entries_decimate');
            $table->float('entries_offer', 8,2);
            $table->float('entries_other', 8,2);  
            $table->float('entries_end', 8,2); 
                 
            //$table->float('entries_balance_end', 8,2);
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
        Schema::dropIfExists('entries');
    }
}

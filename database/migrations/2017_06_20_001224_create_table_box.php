<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBox extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxies', function (Blueprint $table) {
            $table->increments('boxies_id');
            $table->date('boxies_date_open');
            $table->date('boxies_date_close');
            $table->date('boxies_month_year');
            $table->float('boxies_balance_end');
            $table->string('boxies_status');
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
        Schema::dropIfExists('boxies');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountChild extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relation_launch_bank', function (Blueprint $table) {
            $table->integer('accountBank_parent')->nullable();
            $table->integer('accountBank_child')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relation_launch_bank', function (Blueprint $table) {
            $table->dropColumn(['accountBank_parent', 'accountBank_child']);
        });
    }
}
